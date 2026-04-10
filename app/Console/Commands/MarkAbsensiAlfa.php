<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use App\Models\HariLibur;
use App\Models\Izin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkAbsensiAlfa extends Command
{
    protected $signature = 'absensi:mark-alfa {--tanggal= : Tanggal target (Y-m-d), default hari ini}';

    protected $description = 'Tandai karyawan yang tidak absen sebagai Alfa, kecuali hari libur atau punya izin disetujui.';

    public function handle(): int
    {
        $tanggal = $this->option('tanggal')
            ? Carbon::parse($this->option('tanggal'))->toDateString()
            : today()->toDateString();

        $hari = Carbon::parse($tanggal)->dayOfWeek;

        // Lewati hari Sabtu (6) dan Minggu (0)
        if ($hari === Carbon::SATURDAY || $hari === Carbon::SUNDAY) {
            $this->info("Lewati {$tanggal} — hari libur mingguan.");

            return self::SUCCESS;
        }

        // Lewati jika tanggal merah
        if (HariLibur::isLibur($tanggal)) {
            $namaLibur = HariLibur::namaLibur($tanggal);
            $this->info("Lewati {$tanggal} — hari libur: {$namaLibur}.");

            return self::SUCCESS;
        }

        $karyawan = User::where('role_id', 2)->get();
        $marked = 0;

        foreach ($karyawan as $user) {
            // Sudah punya record absensi hari ini → skip
            $sudahAbsen = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', $tanggal)
                ->exists();

            if ($sudahAbsen) {
                continue;
            }

            // Punya izin disetujui yang mencakup tanggal ini → skip
            $adaIzin = Izin::where('user_id', $user->id)
                ->where('status', 'Disetujui')
                ->where('tanggal_mulai', '<=', $tanggal)
                ->where('tanggal_selesai', '>=', $tanggal)
                ->exists();

            if ($adaIzin) {
                continue;
            }

            Absensi::create([
                'user_id' => $user->id,
                'tanggal' => $tanggal,
                'status' => 'Alfa',
            ]);

            $marked++;
            $this->line("  Alfa → {$user->name}");
        }

        $this->info("Selesai: {$marked} karyawan ditandai Alfa pada {$tanggal}.");

        return self::SUCCESS;
    }
}
