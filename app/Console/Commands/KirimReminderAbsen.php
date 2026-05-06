<?php

namespace App\Console\Commands;

use App\Mail\ReminderAbsen;
use App\Models\Absensi;
use App\Models\HariLibur;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class KirimReminderAbsen extends Command
{
    protected $signature = 'absensi:kirim-reminder {--tanggal= : Tanggal target (Y-m-d), default hari ini}';

    protected $description = 'Kirim email reminder absen ke karyawan yang belum absen hari ini.';

    public function handle(): int
    {
        $tanggal = $this->option('tanggal')
            ? Carbon::parse($this->option('tanggal'))->toDateString()
            : today()->toDateString();

        $hari = Carbon::parse($tanggal)->dayOfWeek;

        if ($hari === Carbon::SATURDAY || $hari === Carbon::SUNDAY) {
            $this->info("Lewati {$tanggal} — akhir pekan.");

            return self::SUCCESS;
        }

        if (HariLibur::isLibur($tanggal)) {
            $this->info("Lewati {$tanggal} — hari libur: ".HariLibur::namaLibur($tanggal));

            return self::SUCCESS;
        }

        $karyawan = User::where('role_id', 2)->get();
        $terkirim = 0;

        foreach ($karyawan as $user) {
            $sudahAbsen = Absensi::where('user_id', $user->id)
                ->whereDate('tanggal', $tanggal)
                ->exists();

            if ($sudahAbsen) {
                continue;
            }

            Mail::to($user->email)->queue(new ReminderAbsen($user));
            $terkirim++;
            $this->line("  Reminder → {$user->name} ({$user->email})");
        }

        $this->info("Selesai: {$terkirim} reminder dikirim untuk {$tanggal}.");

        return self::SUCCESS;
    }
}
