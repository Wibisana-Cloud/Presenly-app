<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\HariLibur;
use App\Models\Izin;
use App\Models\JadwalModeKerja;
use App\Models\LokasiKerja;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $lokasiKerja = LokasiKerja::first();

        $absensiHariIni = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', today())
            ->first();

        $absenBulanIni = Absensi::where('user_id', $user->id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->get();

        $totalHadir = $absenBulanIni->where('status', 'Hadir')->count();
        $totalTerlambat = $absenBulanIni->where('status', 'Terlambat')->count();
        $totalAlfa = $absenBulanIni->where('status', 'Alfa')->count();
        $totalIzin = $absenBulanIni->where('status', 'Izin')->count();

        $persentaseHadir = now()->day > 0
            ? round(($totalHadir + $totalTerlambat) / now()->day * 100)
            : 0;

        $riwayatTerbaru = Absensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        // ── HARI LIBUR NASIONAL ──
        $hariIniLibur = HariLibur::isLibur(today()->toDateString());
        $namaHariLibur = $hariIniLibur
            ? HariLibur::namaLibur(today()->toDateString())
            : null;

        // ── MODE KERJA HARI INI (dari jadwal admin) ──
        $modeHariIni = JadwalModeKerja::modeUntukTanggal(today()->toDateString());
        $jadwalModeHariIni = \App\Models\JadwalModeKerja::where('tanggal', today()->toDateString())->first();

        // ── AKHIR PEKAN (Sabtu=6, Minggu=0) ──
        $hariIniAkhirPekan = in_array(now()->dayOfWeek, [0, 6]);
        $namaAkhirPekan = now()->dayOfWeek === 0 ? 'Minggu' : 'Sabtu';

        // ── PENGUMUMAN AKTIF ──
        $pengumuman = Pengumuman::aktif()
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        // ── NOTIFIKASI IZIN DIPROSES (3 hari terakhir) ──
        $izinDiproses = Izin::where('user_id', $user->id)
            ->whereIn('status', ['Disetujui', 'Ditolak'])
            ->where('diproses_at', '>=', now()->subDays(3))
            ->orderBy('diproses_at', 'desc')
            ->get();

        // ── GRAFIK 6 BULAN TERAKHIR (single query) ──
        $awalGrafik = now()->subMonths(5)->startOfMonth()->toDateString();
        $dataGrafik = Absensi::where('user_id', $user->id)
            ->where('tanggal', '>=', $awalGrafik)
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, status, COUNT(*) as total")
            ->groupBy('bulan', 'status')
            ->get()
            ->groupBy('bulan');

        $grafikLabels = [];
        $grafikHadir = [];
        $grafikTerlambat = [];
        $grafikAlfa = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulanTarget = now()->subMonths($i);
            $key = $bulanTarget->format('Y-m');
            $bulanan = $dataGrafik->get($key, collect());

            $grafikLabels[] = $bulanTarget->translatedFormat('M Y');
            $grafikHadir[] = $bulanan->where('status', 'Hadir')->sum('total');
            $grafikTerlambat[] = $bulanan->where('status', 'Terlambat')->sum('total');
            $grafikAlfa[] = $bulanan->where('status', 'Alfa')->sum('total');
        }

        $jamMasuk = $lokasiKerja?->jam_masuk ? \Carbon\Carbon::parse($lokasiKerja->jam_masuk)->format('H:i') : null;
        $jamPulang = $lokasiKerja?->jam_pulang ? \Carbon\Carbon::parse($lokasiKerja->jam_pulang)->format('H:i') : null;

        return view('dashboard', compact(
            'lokasiKerja',
            'jamMasuk',
            'jamPulang',
            'absensiHariIni',
            'modeHariIni',
            'jadwalModeHariIni',
            'totalHadir',
            'totalTerlambat',
            'totalAlfa',
            'totalIzin',
            'persentaseHadir',
            'riwayatTerbaru',
            'hariIniLibur',
            'namaHariLibur',
            'hariIniAkhirPekan',
            'namaAkhirPekan',
            'izinDiproses',
            'grafikLabels',
            'grafikHadir',
            'grafikTerlambat',
            'grafikAlfa',
            'pengumuman'
        ));
    }
}
