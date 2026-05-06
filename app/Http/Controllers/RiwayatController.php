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
        $namaBulan = \Carbon\Carbon::createFromDate(null, (int) $bulan)->translatedFormat('F');

        return view('exports.riwayat-pdf', compact('riwayat', 'user', 'bulan', 'tahun', 'namaBulan'));
    }

    // ── EXPORT EXCEL ──
    public function exportCsv(Request $request): \Illuminate\Http\Response
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $riwayat = Absensi::where('user_id', Auth::id())
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $user = Auth::user();
        $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
        $filename = "rekap_absensi_{$namaBulan}_{$tahun}.xls";

        $totalHadir = $riwayat->where('status', 'Hadir')->count();
        $totalTerlambat = $riwayat->where('status', 'Terlambat')->count();
        $totalAlfa = $riwayat->where('status', 'Alfa')->count();
        $totalIzin = $riwayat->where('status', 'Izin')->count();

        $html = view('exports.riwayat-excel', compact(
            'riwayat', 'user', 'namaBulan', 'tahun',
            'totalHadir', 'totalTerlambat', 'totalAlfa', 'totalIzin'
        ))->render();

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}
