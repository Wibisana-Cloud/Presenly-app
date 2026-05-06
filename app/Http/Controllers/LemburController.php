<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Lembur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LemburController extends Controller
{
    // ── KARYAWAN: Daftar Lembur Sendiri ──
    public function index(Request $request): \Illuminate\View\View
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $lemburans = Lembur::where('user_id', Auth::id())
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        $tahunList = Lembur::where('user_id', Auth::id())
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        if ($tahunList->isEmpty()) {
            $tahunList = collect([now()->year]);
        }

        return view('lembur', compact('lemburans', 'bulan', 'tahun', 'tahunList'));
    }

    // ── KARYAWAN: Ajukan Lembur ──
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $mulai = \Carbon\Carbon::parse($request->jam_mulai);
        $selesai = \Carbon\Carbon::parse($request->jam_selesai);
        $menit = $mulai->diffInMinutes($selesai);
        $durasi = floor($menit / 60).' jam '.($menit % 60).' menit';

        Lembur::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai.':00',
            'jam_selesai' => $request->jam_selesai.':00',
            'durasi_lembur' => $durasi,
            'keterangan' => $request->keterangan,
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Pengajuan lembur berhasil dikirim.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $lembur = Lembur::where('user_id', Auth::id())->where('status', 'Pending')->findOrFail($id);
        $lembur->delete();

        return back()->with('success', 'Pengajuan lembur berhasil dibatalkan.');
    }

    // ── ADMIN: Daftar Semua Lembur ──
    public function adminIndex(Request $request): \Illuminate\View\View
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);
        $search = $request->input('search', '');
        $status = $request->input('status', '');

        $lemburans = Lembur::with('user')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->when($search, fn ($q) => $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        $tahunList = Lembur::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        if ($tahunList->isEmpty()) {
            $tahunList = collect([now()->year]);
        }

        $totalPending = Lembur::where('status', 'Pending')->count();
        $totalDisetujui = Lembur::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Disetujui')->count();

        return view('admin.lembur', compact('lemburans', 'bulan', 'tahun', 'search', 'status', 'tahunList', 'totalPending', 'totalDisetujui'));
    }

    public function approve(int $id): RedirectResponse
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->update([
            'status' => 'Disetujui',
            'diproses_oleh' => Auth::id(),
            'diproses_at' => now(),
        ]);

        AuditLog::catat('Approve Lembur', "Menyetujui lembur {$lembur->user->name} tanggal {$lembur->tanggal->format('Y-m-d')}", 'Lembur', $lembur->id);

        return back()->with('success', 'Lembur disetujui.');
    }

    public function reject(int $id): RedirectResponse
    {
        $lembur = Lembur::findOrFail($id);
        $lembur->update([
            'status' => 'Ditolak',
            'diproses_oleh' => Auth::id(),
            'diproses_at' => now(),
        ]);

        AuditLog::catat('Tolak Lembur', "Menolak lembur {$lembur->user->name} tanggal {$lembur->tanggal->format('Y-m-d')}", 'Lembur', $lembur->id);

        return back()->with('success', 'Lembur ditolak.');
    }
}
