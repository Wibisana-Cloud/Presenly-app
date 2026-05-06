<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\JadwalModeKerja;
use App\Models\LokasiKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    // =====================
    // ABSEN MASUK
    // =====================
    public function absenMasuk(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        // Mode ditentukan oleh jadwal admin, bukan karyawan
        $modeKerja = JadwalModeKerja::modeUntukTanggal(now()->toDateString());

        // Cek sudah absen hari ini
        $cek = Absensi::where('user_id', $user->id)
            ->where('tanggal', now()->toDateString())
            ->first();

        if ($cek) {
            return response()->json([
                'message' => 'Anda sudah absen hari ini!',
            ], 422);
        }

        // Ambil lokasi kerja
        $lokasi = LokasiKerja::first();

        // Hitung jarak sekali saja
        $jarakMeter = 0;
        if ($lokasi) {
            $jarakMeter = round($this->hitungJarak(
                $request->latitude,
                $request->longitude,
                $lokasi->latitude,
                $lokasi->longitude
            ));
        }

        // Validasi radius HANYA jika mode WFO
        if ($modeKerja === 'WFO' && $lokasi && $jarakMeter > $lokasi->radius_meter) {
            return response()->json([
                'message' => 'Anda berada di luar area kantor ('.$jarakMeter.' meter). Aktifkan mode WFA jika ingin absen remote.',
            ], 403);
        }

        // Tolak check-in jika sudah melewati jam masuk
        $jamMasukSekarang = now()->format('H:i:s');
        $batasJamMasuk = $lokasi?->jam_masuk ?? '08:00:00';

        if ($jamMasukSekarang > $batasJamMasuk) {
            return response()->json([
                'message' => 'Sudah melewati jam masuk ('.\Carbon\Carbon::parse($batasJamMasuk)->format('H:i').'). Anda terhitung Alfa hari ini.',
            ], 422);
        }

        $status = 'Hadir';

        // Simpan absensi
        Absensi::create([
            'user_id' => $user->id,
            'tanggal' => now()->toDateString(),
            'jam_masuk' => $jamMasukSekarang,
            'latitude_absen' => $request->latitude,
            'longitude_absen' => $request->longitude,
            'jarak_meter' => $jarakMeter,
            'status' => $status,
            'mode_kerja' => $modeKerja,
        ]);

        $pesanMode = $modeKerja === 'WFA' ? ' (WFA)' : '';

        return response()->json([
            'message' => 'Absen masuk berhasil! Status: '.$status.$pesanMode,
        ], 200);
    }

    // =====================
    // ABSEN PULANG
    // =====================
    public function absenPulang(Request $request)
    {
        $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $user = Auth::user();

        $absensi = Absensi::where('user_id', $user->id)
            ->where('tanggal', now()->toDateString())
            ->whereNotNull('jam_masuk')
            ->whereNull('jam_pulang')
            ->first();

        if (! $absensi) {
            return response()->json([
                'message' => 'Data absen masuk tidak ditemukan!',
            ], 422);
        }

        // Tolak check-out jika belum mencapai jam pulang
        $lokasi = LokasiKerja::first();
        $batasJamPulang = $lokasi?->jam_pulang;

        if ($batasJamPulang && now()->format('H:i:s') < $batasJamPulang) {
            return response()->json([
                'message' => 'Check-out hanya bisa dilakukan mulai pukul '.\Carbon\Carbon::parse($batasJamPulang)->format('H:i').'.',
            ], 422);
        }

        $jamPulang = now()->format('H:i:s');
        $jamMasuk = \Carbon\Carbon::parse($absensi->jam_masuk);
        $jamPulangDt = \Carbon\Carbon::parse($jamPulang);
        $durasiMenit = $jamMasuk->diffInMinutes($jamPulangDt);
        $durasiJam = floor($durasiMenit / 60);
        $durasiSisa = $durasiMenit % 60;
        $durasi = $durasiJam.' jam '.$durasiSisa.' menit';

        $absensi->update([
            'jam_pulang' => $jamPulang,
            'durasi_kerja' => $durasi,
        ]);

        return response()->json([
            'message' => 'Absen pulang berhasil! Durasi kerja: '.$durasi,
        ], 200);
    }

    // =====================
    // HITUNG JARAK (Haversine)
    // =====================
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371000;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                sin($dLon / 2) * sin($dLon / 2);

        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
