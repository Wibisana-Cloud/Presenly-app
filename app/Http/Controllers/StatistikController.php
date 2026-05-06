<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $karyawan = User::where('role_id', 2)->orderBy('name')->get();

        // Statistik keterlambatan per karyawan
        $statistik = $karyawan->map(function (User $user) use ($bulan, $tahun) {
            $absensiTerlambat = Absensi::where('user_id', $user->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->where('status', 'Terlambat')
                ->get();

            $totalMenitTerlambat = $absensiTerlambat->sum(function ($absen) {
                if (! $absen->jam_masuk) {
                    return 0;
                }

                $batas = Carbon::parse($absen->tanggal->format('Y-m-d').' '.($absen->batasJamMasuk ?? '08:00:00'));
                $masuk = Carbon::parse($absen->tanggal->format('Y-m-d').' '.$absen->jam_masuk);

                return max(0, $batas->diffInMinutes($masuk, false));
            });

            $totalHadir = Absensi::where('user_id', $user->id)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->whereIn('status', ['Hadir', 'Terlambat'])->count();
            $totalAlfa = Absensi::where('user_id', $user->id)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Alfa')->count();
            $totalIzin = Absensi::where('user_id', $user->id)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'Izin')->count();

            return [
                'user' => $user,
                'total_terlambat' => $absensiTerlambat->count(),
                'total_menit_terlambat' => $totalMenitTerlambat,
                'rata_menit_terlambat' => $absensiTerlambat->count() > 0 ? round($totalMenitTerlambat / $absensiTerlambat->count()) : 0,
                'total_hadir' => $totalHadir,
                'total_alfa' => $totalAlfa,
                'total_izin' => $totalIzin,
            ];
        })->sortByDesc('total_terlambat')->values();

        // Top 5 paling sering terlambat
        $top5Terlambat = $statistik->take(5);

        // Tren keterlambatan 6 bulan terakhir (semua karyawan)
        $trenLabels = [];
        $trenData = [];
        for ($i = 5; $i >= 0; $i--) {
            $target = now()->subMonths($i);
            $trenLabels[] = $target->translatedFormat('M Y');
            $trenData[] = Absensi::whereMonth('tanggal', $target->month)
                ->whereYear('tanggal', $target->year)
                ->where('status', 'Terlambat')
                ->count();
        }

        $tahunList = Absensi::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        if ($tahunList->isEmpty()) {
            $tahunList = collect([now()->year]);
        }

        return view('admin.statistik', compact(
            'statistik', 'top5Terlambat', 'bulan', 'tahun',
            'trenLabels', 'trenData', 'tahunList'
        ));
    }
}
