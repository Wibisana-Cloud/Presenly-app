<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Tandai Alfa setiap hari pukul 23:59
Schedule::command('absensi:mark-alfa')->dailyAt('23:59');

// Kirim reminder absen setiap hari kerja pukul 08:30
Schedule::command('absensi:kirim-reminder')->dailyAt('08:30')->weekdays();
