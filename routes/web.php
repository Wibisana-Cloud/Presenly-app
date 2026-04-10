<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // ── DASHBOARD ──
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── RIWAYAT ──
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/export/pdf', [RiwayatController::class, 'exportPdf'])->name('riwayat.export.pdf');
    Route::get('/riwayat/export/csv', [RiwayatController::class, 'exportCsv'])->name('riwayat.export.csv');

    // ── PROFIL ──
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');

    // ── ABSENSI ──
    Route::post('/absen-masuk', [AbsensiController::class, 'absenMasuk'])->name('absen.masuk');
    Route::post('/absen-pulang', [AbsensiController::class, 'absenPulang'])->name('absen.pulang');

    // ── ADMIN ──
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard/stats', [AdminController::class, 'dashboardStats'])->name('dashboard.stats');
        Route::get('/karyawan', [AdminController::class, 'karyawan'])->name('karyawan');
        Route::post('/karyawan', [AdminController::class, 'karyawanStore'])->name('karyawan.store');
        Route::get('/karyawan/{id}', [AdminController::class, 'karyawanShow'])->name('karyawan.show');
        Route::get('/karyawan/{id}/export/csv', [AdminController::class, 'karyawanExportCsv'])->name('karyawan.export.csv');
        Route::put('/karyawan/{id}', [AdminController::class, 'karyawanUpdate'])->name('karyawan.update');
        Route::delete('/karyawan/{id}', [AdminController::class, 'karyawanDestroy'])->name('karyawan.destroy');
        Route::get('/absensi', [AdminController::class, 'absensi'])->name('absensi');
        Route::get('/export/csv', [AdminController::class, 'exportCsv'])->name('export.csv');
        Route::get('/lokasi', [AdminController::class, 'lokasi'])->name('lokasi');
        Route::put('/lokasi/{id}', [AdminController::class, 'lokasiUpdate'])->name('lokasi.update');
        Route::get('/izin', [IzinController::class, 'adminIndex'])->name('izin');
        Route::patch('/izin/{id}/approve', [IzinController::class, 'approve'])->name('izin.approve');
        Route::patch('/izin/{id}/reject', [IzinController::class, 'reject'])->name('izin.reject');
        Route::get('/hari-libur', [HariLiburController::class, 'index'])->name('hari_libur');
        Route::post('/hari-libur', [HariLiburController::class, 'store'])->name('hari_libur.store');
        Route::post('/hari-libur/sync', [HariLiburController::class, 'sinkronisasi'])->name('hari_libur.sync');
        Route::delete('/hari-libur/{id}', [HariLiburController::class, 'destroy'])->name('hari_libur.destroy');
        Route::get('/jadwal-mode', [AdminController::class, 'jadwalMode'])->name('jadwal_mode');
        Route::post('/jadwal-mode', [AdminController::class, 'jadwalModeStore'])->name('jadwal_mode.store');
        Route::delete('/jadwal-mode/{id}', [AdminController::class, 'jadwalModeDestroy'])->name('jadwal_mode.destroy');
        Route::get('/audit-log', [AuditLogController::class, 'index'])->name('audit_log');
    });

    // ── IZIN ──
    Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
    Route::post('/izin', [IzinController::class, 'store'])->name('izin.store');
    Route::delete('/izin/{id}', [IzinController::class, 'destroy'])->name('izin.destroy');
});

require __DIR__.'/auth.php';
