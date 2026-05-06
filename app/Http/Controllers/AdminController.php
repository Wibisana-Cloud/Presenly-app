<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\AuditLog;
use App\Models\JadwalModeKerja;
use App\Models\LokasiKerja;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // ── DASHBOARD ADMIN ──
    public function dashboard(): \Illuminate\View\View
    {
        $totalKaryawan = User::where('role_id', 2)->count();
        $totalAbsensiHariIni = Absensi::whereDate('tanggal', today())->count();
        $hadirHariIni = Absensi::whereDate('tanggal', today())->where('status', 'Hadir')->count();
        $terlambatHariIni = Absensi::whereDate('tanggal', today())->where('status', 'Terlambat')->count();
        $alfaHariIni = Absensi::whereDate('tanggal', today())->where('status', 'Alfa')->count();
        $wfoHariIni = Absensi::whereDate('tanggal', today())->where('mode_kerja', 'WFO')->count();
        $wfaHariIni = Absensi::whereDate('tanggal', today())->where('mode_kerja', 'WFA')->count();
        $modeHariIni = JadwalModeKerja::modeUntukTanggal(today()->toDateString());

        $absensiTerbaru = Absensi::with('user')
            ->whereDate('tanggal', today())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $bulanIni = Absensi::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->get();

        $totalHadirBulan = $bulanIni->where('status', 'Hadir')->count();
        $totalTerlambatBulan = $bulanIni->where('status', 'Terlambat')->count();
        $totalAlfaBulan = $bulanIni->where('status', 'Alfa')->count();

        // ── GRAFIK HARIAN (bulan ini s.d. hari ini) ──
        $grafikRaw = Absensi::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->selectRaw('DAY(tanggal) as hari, status, COUNT(*) as total')
            ->groupBy('hari', 'status')
            ->get()
            ->groupBy('hari');

        $grafikLabels = [];
        $grafikHadir = [];
        $grafikTerlambat = [];
        $grafikAlfa = [];

        for ($d = 1; $d <= now()->day; $d++) {
            $data = $grafikRaw->get($d) ?? collect();
            $grafikLabels[] = $d;
            $grafikHadir[] = (int) ($data->firstWhere('status', 'Hadir')->total ?? 0);
            $grafikTerlambat[] = (int) ($data->firstWhere('status', 'Terlambat')->total ?? 0);
            $grafikAlfa[] = (int) ($data->firstWhere('status', 'Alfa')->total ?? 0);
        }

        return view('admin.dashboard', compact(
            'totalKaryawan', 'totalAbsensiHariIni',
            'hadirHariIni', 'terlambatHariIni', 'alfaHariIni',
            'wfoHariIni', 'wfaHariIni', 'modeHariIni',
            'absensiTerbaru',
            'totalHadirBulan', 'totalTerlambatBulan', 'totalAlfaBulan',
            'grafikLabels', 'grafikHadir', 'grafikTerlambat', 'grafikAlfa'
        ));
    }

    // ── DASHBOARD STATS (JSON untuk auto-refresh) ──
    public function dashboardStats(): \Illuminate\Http\JsonResponse
    {
        $hadirHariIni = Absensi::whereDate('tanggal', today())->where('status', 'Hadir')->count();
        $terlambatHariIni = Absensi::whereDate('tanggal', today())->where('status', 'Terlambat')->count();
        $alfaHariIni = Absensi::whereDate('tanggal', today())->where('status', 'Alfa')->count();
        $wfoHariIni = Absensi::whereDate('tanggal', today())->where('mode_kerja', 'WFO')->count();
        $wfaHariIni = Absensi::whereDate('tanggal', today())->where('mode_kerja', 'WFA')->count();

        $absensiTerbaru = Absensi::with('user')
            ->whereDate('tanggal', today())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(fn ($item) => [
                'name' => $item->user->name ?? '-',
                'email' => $item->user->email ?? '-',
                'jam_masuk' => $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-',
                'jam_pulang' => $item->jam_pulang ? \Carbon\Carbon::parse($item->jam_pulang)->format('H:i') : '-',
                'jarak_meter' => $item->jarak_meter ? number_format($item->jarak_meter, 0).' m' : '-',
                'durasi_kerja' => $item->durasi_kerja ?? '-',
                'status' => $item->status ?? '-',
            ]);

        return response()->json([
            'hadirHariIni' => $hadirHariIni,
            'terlambatHariIni' => $terlambatHariIni,
            'alfaHariIni' => $alfaHariIni,
            'wfoHariIni' => $wfoHariIni,
            'wfaHariIni' => $wfaHariIni,
            'absensiTerbaru' => $absensiTerbaru,
            'updatedAt' => now()->format('H:i:s'),
        ]);
    }

    // ── DAFTAR KARYAWAN ──
    public function karyawan(Request $request): \Illuminate\View\View
    {
        $search = $request->input('search', '');

        $karyawan = User::where('role_id', 2)
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            }))
            ->orderBy('name')
            ->get();

        $lokasi = LokasiKerja::all();
        $totalKaryawan = User::where('role_id', 2)->count();

        return view('admin.karyawan', compact('karyawan', 'lokasi', 'search', 'totalKaryawan'));
    }

    // ── REKAP ABSENSI PER KARYAWAN ──
    public function karyawanShow(Request $request, int $id): \Illuminate\View\View
    {
        $user = User::where('role_id', 2)->findOrFail($id);
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $baseQuery = Absensi::where('user_id', $id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        $totalHadir = (clone $baseQuery)->where('status', 'Hadir')->count();
        $totalTerlambat = (clone $baseQuery)->where('status', 'Terlambat')->count();
        $totalWFA = (clone $baseQuery)->where('mode_kerja', 'WFA')->count();
        $totalWFO = (clone $baseQuery)->where('mode_kerja', 'WFO')->count();
        $totalAbsensi = (clone $baseQuery)->count();

        $absensi = (clone $baseQuery)
            ->orderBy('tanggal', 'desc')
            ->paginate(15)
            ->withQueryString();

        $tahunList = Absensi::where('user_id', $id)
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        if ($tahunList->isEmpty()) {
            $tahunList = collect([now()->year]);
        }

        return view('admin.rekap_karyawan', compact(
            'user', 'absensi', 'bulan', 'tahun',
            'totalHadir', 'totalTerlambat', 'totalWFA', 'totalWFO',
            'totalAbsensi', 'tahunList'
        ));
    }

    // ── EXPORT CSV REKAP PER KARYAWAN ──
    public function karyawanExportCsv(Request $request, int $id): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $user = User::where('role_id', 2)->findOrFail($id);
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $absensi = Absensi::where('user_id', $id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
        $namaFile = 'rekap_'.Str::slug($user->name)."_{$namaBulan}_{$tahun}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$namaFile}\"",
        ];

        $callback = function () use ($user, $absensi, $namaBulan, $tahun) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ["Rekap Absensi: {$user->name} — {$namaBulan} {$tahun}"]);
            fputcsv($file, ["Email: {$user->email}"]);
            fputcsv($file, []);
            fputcsv($file, ['No', 'Tanggal', 'Hari', 'Jam Masuk', 'Jam Pulang', 'Durasi', 'Jarak (m)', 'Mode', 'Status']);

            foreach ($absensi as $i => $row) {
                fputcsv($file, [
                    $i + 1,
                    \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y'),
                    \Carbon\Carbon::parse($row->tanggal)->translatedFormat('l'),
                    $row->jam_masuk ? \Carbon\Carbon::parse($row->jam_masuk)->format('H:i') : '-',
                    $row->jam_pulang ? \Carbon\Carbon::parse($row->jam_pulang)->format('H:i') : '-',
                    $row->durasi_kerja ?? '-',
                    $row->jarak_meter ? number_format($row->jarak_meter, 0, ',', '.') : '-',
                    $row->mode_kerja ?? '-',
                    $row->status ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── EXPORT PDF REKAP PER KARYAWAN ──
    public function karyawanExportPdf(Request $request, int $id): \Illuminate\View\View
    {
        $user = User::where('role_id', 2)->findOrFail($id);
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $absensi = Absensi::where('user_id', $id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');

        return view('admin.exports.rekap-karyawan-pdf', compact('user', 'absensi', 'bulan', 'tahun', 'namaBulan'));
    }

    // ── TAMBAH KARYAWAN ──
    public function karyawanStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $karyawan = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);

        AuditLog::catat('Tambah Karyawan', "Menambahkan karyawan baru: {$karyawan->name} ({$karyawan->email})", 'User', $karyawan->id);

        return back()->with('success', 'Karyawan berhasil ditambahkan!');
    }

    // ── EDIT KARYAWAN ──
    public function karyawanUpdate(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        if ($user->role_id === 1) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        AuditLog::catat('Edit Karyawan', "Mengubah data karyawan: {$user->name} ({$user->email})", 'User', $user->id);

        return back()->with('success', 'Data karyawan berhasil diperbarui!');
    }

    // ── HAPUS KARYAWAN ──
    public function karyawanDestroy($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        if ($user->role_id === 1) {
            abort(403);
        }

        AuditLog::catat('Hapus Karyawan', "Menghapus karyawan: {$user->name} ({$user->email})", 'User', $user->id);

        $user->delete();

        return back()->with('success', 'Karyawan berhasil dihapus.');
    }

    // ── SEMUA ABSENSI ──
    public function absensi(Request $request): \Illuminate\View\View
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search', '');
        $mode = $request->input('mode', '');
        $tanggalDari = $request->input('tanggal_dari', '');
        $tanggalSampai = $request->input('tanggal_sampai', '');

        $useDateRange = $tanggalDari && $tanggalSampai;

        $query = Absensi::with('user')
            ->when($useDateRange, function ($q) use ($tanggalDari, $tanggalSampai) {
                $q->whereBetween('tanggal', [$tanggalDari, $tanggalSampai]);
            }, function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            })
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%$search%"));
            })
            ->when($mode, function ($q) use ($mode) {
                $q->where('mode_kerja', $mode);
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc');

        $absensi = $query->paginate(20);

        $statsBase = Absensi::query()
            ->when($useDateRange, function ($q) use ($tanggalDari, $tanggalSampai) {
                $q->whereBetween('tanggal', [$tanggalDari, $tanggalSampai]);
            }, function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            });
        $totalWFO = (clone $statsBase)->where('mode_kerja', 'WFO')->count();
        $totalWFA = (clone $statsBase)->where('mode_kerja', 'WFA')->count();

        $tahunList = Absensi::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        if ($tahunList->isEmpty()) {
            $tahunList = collect([now()->year]);
        }

        return view('admin.absensi', compact(
            'absensi', 'bulan', 'tahun', 'search', 'tahunList',
            'totalWFO', 'totalWFA', 'tanggalDari', 'tanggalSampai', 'useDateRange'
        ));
    }

    // ── EXPORT CSV SEMUA ABSENSI ──
    public function exportCsv(Request $request): \Illuminate\Http\Response
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);
        $tanggalDari = $request->input('tanggal_dari', '');
        $tanggalSampai = $request->input('tanggal_sampai', '');
        $useDateRange = $tanggalDari && $tanggalSampai;

        $absensi = Absensi::with('user')
            ->when($useDateRange, function ($q) use ($tanggalDari, $tanggalSampai) {
                $q->whereBetween('tanggal', [$tanggalDari, $tanggalSampai]);
            }, function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            })
            ->orderBy('tanggal', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        if ($useDateRange) {
            $periodeLabel = \Carbon\Carbon::parse($tanggalDari)->translatedFormat('d F Y')
                .' s/d '
                .\Carbon\Carbon::parse($tanggalSampai)->translatedFormat('d F Y');
            $filename = "rekap_absensi_{$tanggalDari}_{$tanggalSampai}.xls";
        } else {
            $namaBulan = \Carbon\Carbon::createFromDate(null, $bulan)->translatedFormat('F');
            $periodeLabel = "{$namaBulan} {$tahun}";
            $filename = "rekap_absensi_{$namaBulan}_{$tahun}.xls";
        }

        $html = view('admin.exports.absensi-excel', compact('absensi', 'periodeLabel'))->render();

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }

    // ── JADWAL MODE KERJA ──
    public function jadwalMode(): \Illuminate\View\View
    {
        $jadwals = JadwalModeKerja::with('dibuatOleh')
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('admin.jadwal_mode', compact('jadwals'));
    }

    public function jadwalModeStore(Request $request): RedirectResponse
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'mode' => 'required|in:WFO,WFA',
            'keterangan' => 'nullable|string|max:200',
        ]);

        JadwalModeKerja::updateOrCreate(
            ['tanggal' => $request->tanggal],
            [
                'mode' => $request->mode,
                'keterangan' => $request->keterangan,
                'dibuat_oleh' => Auth::id(),
            ]
        );

        AuditLog::catat('Jadwal Mode Kerja', "Menetapkan mode {$request->mode} untuk tanggal {$request->tanggal}", 'JadwalModeKerja');

        return back()->with('success', "Jadwal mode {$request->mode} untuk {$request->tanggal} berhasil disimpan.");
    }

    public function jadwalModeDestroy($id): RedirectResponse
    {
        $jadwal = JadwalModeKerja::findOrFail($id);
        $info = "mode {$jadwal->mode} tanggal {$jadwal->tanggal->format('Y-m-d')}";
        $jadwal->delete();

        AuditLog::catat('Hapus Jadwal Mode', "Menghapus jadwal {$info}", 'JadwalModeKerja');

        return back()->with('success', 'Jadwal mode kerja berhasil dihapus.');
    }

    // ── KOREKSI ABSENSI: TAMBAH MANUAL ──
    public function absensiStore(Request $request, int $id): RedirectResponse
    {
        $user = User::where('role_id', 2)->findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
            'status' => 'required|in:Hadir,Terlambat,Alfa,Izin',
            'mode_kerja' => 'required|in:WFO,WFA',
        ]);

        $existing = Absensi::where('user_id', $id)->whereDate('tanggal', $request->tanggal)->first();
        if ($existing) {
            return back()->with('error', 'Sudah ada data absensi pada tanggal tersebut.');
        }

        $durasi = null;
        if ($request->jam_masuk && $request->jam_pulang) {
            $masuk = \Carbon\Carbon::parse($request->jam_masuk);
            $pulang = \Carbon\Carbon::parse($request->jam_pulang);
            $menit = $masuk->diffInMinutes($pulang);
            $durasi = floor($menit / 60).' jam '.($menit % 60).' menit';
        }

        Absensi::create([
            'user_id' => $id,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk ? $request->jam_masuk.':00' : null,
            'jam_pulang' => $request->jam_pulang ? $request->jam_pulang.':00' : null,
            'durasi_kerja' => $durasi,
            'status' => $request->status,
            'mode_kerja' => $request->mode_kerja,
            'jarak_meter' => 0,
            'latitude_absen' => 0,
            'longitude_absen' => 0,
        ]);

        AuditLog::catat('Koreksi Absensi', "Menambah absensi manual untuk {$user->name} tanggal {$request->tanggal}", 'Absensi');

        return back()->with('success', 'Data absensi berhasil ditambahkan.');
    }

    // ── KOREKSI ABSENSI: EDIT ──
    public function absensiUpdate(Request $request, int $id): RedirectResponse
    {
        $absensi = Absensi::findOrFail($id);

        $request->validate([
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i',
            'status' => 'required|in:Hadir,Terlambat,Alfa,Izin',
            'mode_kerja' => 'required|in:WFO,WFA',
        ]);

        $durasi = $absensi->durasi_kerja;
        if ($request->jam_masuk && $request->jam_pulang) {
            $masuk = \Carbon\Carbon::parse($request->jam_masuk);
            $pulang = \Carbon\Carbon::parse($request->jam_pulang);
            $menit = $masuk->diffInMinutes($pulang);
            $durasi = floor($menit / 60).' jam '.($menit % 60).' menit';
        }

        $absensi->update([
            'jam_masuk' => $request->jam_masuk ? $request->jam_masuk.':00' : null,
            'jam_pulang' => $request->jam_pulang ? $request->jam_pulang.':00' : null,
            'durasi_kerja' => $durasi,
            'status' => $request->status,
            'mode_kerja' => $request->mode_kerja,
        ]);

        AuditLog::catat('Koreksi Absensi', "Mengedit absensi ID {$id} tanggal {$absensi->tanggal}", 'Absensi', $id);

        return back()->with('success', 'Data absensi berhasil diperbarui.');
    }

    // ── KOREKSI ABSENSI: HAPUS ──
    public function absensiDestroy(int $id): RedirectResponse
    {
        $absensi = Absensi::findOrFail($id);
        AuditLog::catat('Hapus Absensi', "Menghapus absensi ID {$id} tanggal {$absensi->tanggal}", 'Absensi', $id);
        $absensi->delete();

        return back()->with('success', 'Data absensi berhasil dihapus.');
    }

    // ── KELOLA LOKASI KERJA ──
    public function lokasi(): \Illuminate\View\View
    {
        $lokasi = LokasiKerja::all();

        return view('admin.lokasi', compact('lokasi'));
    }

    public function lokasiUpdate(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_lokasi' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius_meter' => 'required|integer|min:10',
            'jam_masuk' => 'required',
            'jam_pulang' => 'nullable|date_format:H:i',
        ]);

        $lokasi = LokasiKerja::findOrFail($id);
        $lokasi->update($request->only([
            'nama_lokasi', 'latitude', 'longitude', 'radius_meter', 'jam_masuk', 'jam_pulang',
        ]));

        AuditLog::catat('Update Lokasi', "Mengubah lokasi kerja: {$lokasi->nama_lokasi} (radius {$lokasi->radius_meter}m, jam masuk {$lokasi->jam_masuk})", 'LokasiKerja', $lokasi->id);

        return back()->with('success', 'Lokasi berhasil diperbarui!');
    }
}
