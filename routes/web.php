<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\StatistikController;
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
        Route::get('/karyawan/{id}/export/pdf', [AdminController::class, 'karyawanExportPdf'])->name('karyawan.export.pdf');
        Route::put('/karyawan/{id}', [AdminController::class, 'karyawanUpdate'])->name('karyawan.update');
        Route::delete('/karyawan/{id}', [AdminController::class, 'karyawanDestroy'])->name('karyawan.destroy');
        Route::get('/absensi', [AdminController::class, 'absensi'])->name('absensi');
        Route::get('/export/csv', [AdminController::class, 'exportCsv'])->name('export.csv');
        Route::post('/karyawan/{id}/absensi', [AdminController::class, 'absensiStore'])->name('karyawan.absensi.store');
        Route::put('/absensi/{id}', [AdminController::class, 'absensiUpdate'])->name('absensi.update');
        Route::delete('/absensi/{id}', [AdminController::class, 'absensiDestroy'])->name('absensi.destroy');
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

        // ── PENGUMUMAN ──
        Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman');
        Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
        Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
        Route::patch('/pengumuman/{id}/toggle', [PengumumanController::class, 'toggleAktif'])->name('pengumuman.toggle');
        Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

        // ── DEPARTEMEN ──
        Route::get('/departemen', [DepartemenController::class, 'index'])->name('departemen');
        Route::post('/departemen', [DepartemenController::class, 'store'])->name('departemen.store');
        Route::put('/departemen/{id}', [DepartemenController::class, 'update'])->name('departemen.update');
        Route::delete('/departemen/{id}', [DepartemenController::class, 'destroy'])->name('departemen.destroy');
        Route::patch('/departemen/assign/{userId}', [DepartemenController::class, 'assignKaryawan'])->name('departemen.assign');

        // ── LEMBUR ADMIN ──
        Route::get('/lembur', [LemburController::class, 'adminIndex'])->name('lembur');
        Route::patch('/lembur/{id}/approve', [LemburController::class, 'approve'])->name('lembur.approve');
        Route::patch('/lembur/{id}/reject', [LemburController::class, 'reject'])->name('lembur.reject');

        // ── STATISTIK KETERLAMBATAN ──
        Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik');

    });

    // ── LEMBUR ──
    Route::get('/lembur', [LemburController::class, 'index'])->name('lembur.index');
    Route::post('/lembur', [LemburController::class, 'store'])->name('lembur.store');
    Route::delete('/lembur/{id}', [LemburController::class, 'destroy'])->name('lembur.destroy');

    // ── IZIN ──
    Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
    Route::post('/izin', [IzinController::class, 'store'])->name('izin.store');
    Route::delete('/izin/{id}', [IzinController::class, 'destroy'])->name('izin.destroy');

});

require __DIR__.'/auth.php';
