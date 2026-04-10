<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $riwayat = Absensi::where('user_id', Auth::id())
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Ringkasan statistik bulan ini
        $totalHadir = $riwayat->where('status', 'Hadir')->count();
        $totalTerlambat = $riwayat->where('status', 'Terlambat')->count();
        $totalAlfa = $riwayat->where('status', 'Alfa')->count();
        $totalIzin = $riwayat->where('status', 'Izin')->count();

        // Daftar tahun untuk dropdown (dari tahun pertama absen sampai sekarang)
        $tahunList = Absensi::where('user_id', Auth::id())
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        if ($tahunList->isEmpty()) {
            $tahunList = collect([now()->year]);
        }

        return view('riwayat', compact(
            'riwayat', 'bulan', 'tahun',
            'totalHadir', 'totalTerlambat', 'totalAlfa', 'totalIzin',
            'tahunList'
        ));
    }

    // ── EXPORT PDF ──
    public function exportPdf(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $riwayat = Absensi::where('user_id', Auth::id())
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $user = Auth::user();
        $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
        $namaBulan = \Carbon\Carbon::create()->month((int) $bulan)->translatedFormat('F');

        return view('exports.riwayat-pdf', compact('riwayat', 'user', 'bulan', 'tahun', 'namaBulan'));
    }

    // ── EXPORT CSV/EXCEL ──
    public function exportCsv(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $riwayat = Absensi::where('user_id', Auth::id())
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
        $filename = "absensi_{$namaBulan}_{$tahun}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($riwayat) {
            $file = fopen('php://output', 'w');

            // Header baris
            fputcsv($file, ['No', 'Tanggal', 'Hari', 'Jam Masuk', 'Jam Pulang', 'Durasi Kerja', 'Jarak (meter)', 'Status']);

            foreach ($riwayat as $i => $row) {
                fputcsv($file, [
                    $i + 1,
                    \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y'),
                    \Carbon\Carbon::parse($row->tanggal)->translatedFormat('l'),
                    $row->jam_masuk ? \Carbon\Carbon::parse($row->jam_masuk)->format('H:i') : '-',
                    $row->jam_pulang ? \Carbon\Carbon::parse($row->jam_pulang)->format('H:i') : '-',
                    $row->durasi_kerja ?? '-',
                    $row->jarak_meter ? number_format($row->jarak_meter, 0, ',', '.') : '-',
                    $row->status ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
