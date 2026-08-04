<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PresensiController;

/*
|--------------------------------------------------------------------------
| Web Routes - Authentication & Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'index'])->name('portal');
Route::get('/login/{role}', [AuthController::class, 'loginRole'])->name('login.role');
Route::post('/login/{role}', [AuthController::class, 'authenticate'])->name('login.perform');
Route::post('/login-scan', [AuthController::class, 'loginByBarcode'])->name('login.scan');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // --- KELOLA SISWA (ADMIN) ---
    Route::get('/siswa', [AdminController::class, 'siswaIndex'])->name('siswa');
    Route::get('/siswa/list', [AdminController::class, 'siswaIndex'])->name('siswa.index');
    Route::get('/siswa/create', [AdminController::class, 'siswaCreate'])->name('siswa.create');
    Route::post('/siswa', [AdminController::class, 'siswaStore'])->name('siswa.store');
    Route::get('/siswa/{id}', [AdminController::class, 'siswaShow'])->name('siswa.show');
    Route::get('/siswa/{id}/edit', [AdminController::class, 'siswaEdit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [AdminController::class, 'siswaUpdate'])->name('siswa.update');
    Route::delete('/siswa/{id}', [AdminController::class, 'siswaDestroy'])->name('siswa.destroy');

    // --- KELOLA KELAS & JURUSAN ---
    Route::get('/kelas', [AdminController::class, 'kelasIndex'])->name('kelas.index');
    Route::get('/jurusan', [AdminController::class, 'jurusanIndex'])->name('jurusan.index');

    // --- KELOLA PETUGAS ---
    Route::get('/petugas', [AdminController::class, 'petugasIndex'])->name('petugas.index');
    Route::post('/petugas', [AdminController::class, 'petugasStore'])->name('petugas.store');
    Route::get('/petugas/{id}/edit', [AdminController::class, 'petugasEdit'])->name('petugas.edit');
    Route::put('/petugas/{id}', [AdminController::class, 'petugasUpdate'])->name('petugas.update');
    Route::delete('/petugas/{id}', [AdminController::class, 'petugasDestroy'])->name('petugas.destroy');

    // Barcode Petugas
    Route::get('/petugas/barcode', [AdminController::class, 'petugasBarcodeGenerate'])->name('petugas.barcode.generate');
    Route::get('/petugas/barcode/{id}/download', [AdminController::class, 'petugasBarcodeDownload'])->name('petugas.barcode.download');

 // --- PRESENSI (Menggunakan PresensiController) ---
Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi');
Route::post('/presensi/scan', [PresensiController::class, 'scanBarcode'])->name('presensi.scan');

    // --- LAPORAN ---
    Route::get('/laporan', [AdminController::class, 'laporanIndex'])->name('laporan');
    Route::get('/laporan/index', [AdminController::class, 'laporanIndex'])->name('laporan.index');
    Route::get('/laporan/harian', [AdminController::class, 'laporanHarian'])->name('laporan.harian');
    Route::get('/laporan/mingguan', [AdminController::class, 'laporanMingguan'])->name('laporan.mingguan');
    Route::get('/laporan/bulanan', [AdminController::class, 'laporanBulanan'])->name('laporan.bulanan');
    Route::get('/laporan/tahunan', [AdminController::class, 'laporanTahunan'])->name('laporan.tahunan');

    // --- BARCODE SISWA & STATISTIK ---
    Route::get('/barcode/generate', [AdminController::class, 'barcodeGenerate'])->name('barcode.generate');
    Route::get('/barcode/download/{id}', [AdminController::class, 'barcodeDownload'])->name('barcode.download');
    Route::get('/statistik/pengunjung', [AdminController::class, 'statistikPengunjung'])->name('statistik.pengunjung');
});
Route::prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');

    // --- PROFIL PETUGAS ---
    Route::get('/profile', [PetugasController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [PetugasController::class, 'profileUpdate'])->name('profile.update');
    Route::put('/profile/password', [PetugasController::class, 'profilePassword'])->name('profile.password');

    // --- SCANNER KAMERA (halaman /petugas/scan terpisah dari modal presensi) ---
    Route::get('/scan', [PetugasController::class, 'scanIndex'])->name('scan');
    Route::post('/scan/process', [PetugasController::class, 'scanProcess'])->name('scan.process');

    // --- KELOLA DATA SISWA (OLEH PETUGAS) ---
    Route::get('/siswa', [PetugasController::class, 'siswaIndex'])->name('siswa');
    Route::get('/siswa/list', [PetugasController::class, 'siswaIndex'])->name('siswa.index');
    Route::get('/siswa/create', [PetugasController::class, 'siswaCreate'])->name('siswa.create');
    Route::post('/siswa', [PetugasController::class, 'siswaStore'])->name('siswa.store');
    Route::get('/siswa/{id}', [PetugasController::class, 'siswaShow'])->name('siswa.show');
    Route::get('/siswa/{id}/edit', [PetugasController::class, 'siswaEdit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [PetugasController::class, 'siswaUpdate'])->name('siswa.update');
    Route::delete('/siswa/{id}', [PetugasController::class, 'siswaDestroy'])->name('siswa.destroy');

    // --- BARCODE SISWA (Akses Petugas) ---
    Route::get('/barcode/generate', [PetugasController::class, 'barcodeGenerate'])->name('barcode.generate');
    Route::get('/barcode/download/{id}', [PetugasController::class, 'barcodeDownload'])->name('barcode.download');

    // --- PRESENSI ---
    Route::get('/presensi', [PetugasController::class, 'presensiIndex'])->name('presensi');
    Route::post('/presensi/scan', [PetugasController::class, 'presensiScan'])->name('presensi.scan');

    // --- LAPORAN ---
    Route::get('/laporan', [PetugasController::class, 'laporanIndex'])->name('laporan');
    Route::get('/laporan/harian', [PetugasController::class, 'laporanHarian'])->name('laporan.harian');
    Route::get('/laporan/mingguan', [PetugasController::class, 'laporanMingguan'])->name('laporan.mingguan');
    Route::get('/laporan/bulanan', [PetugasController::class, 'laporanBulanan'])->name('laporan.bulanan');
    Route::get('/laporan/tahunan', [PetugasController::class, 'laporanTahunan'])->name('laporan.tahunan');

    // --- STATISTIK PENGUNJUNG ---
    Route::get('/statistik/pengunjung', [PetugasController::class, 'statistikPengunjung'])->name('statistik.pengunjung');
});
Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/riwayat', [SiswaController::class, 'riwayat'])->name('riwayat');
});
    Route::get('/profile', [AdminController::class, 'profileIndex'])->name('admin.profile');
    Route::get('/profile/download-barcode', [AdminController::class, 'profileBarcodeDownload'])->name('admin.profile.barcode.download');
    Route::post('/profile/update', [AdminController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::post('/profile/password', [AdminController::class, 'profilePassword'])->name('admin.profile.password');

    Route::middleware(['auth'])->group(function () {
    Route::get('/admin/profile', [AdminController::class, 'profileIndex'])->name('admin.profile');
    Route::get('/admin/profile/download-barcode', [AdminController::class, 'profileBarcodeDownload'])->name('admin.profile.barcode.download');
});

// routes/web.php
Route::get('/admin/profile/barcode/download', [AdminController::class, 'profileBarcodeDownload'])
    ->name('admin.profile.barcode.download');

    Route::post('/login/{role}', [AuthController::class, 'authenticate'])->name('login.authenticate');

use App\Http\Controllers\BukuDigitalController;

Route::middleware(['auth'])->group(function () {

    // === ROUTE ADMIN ===
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/buku', [BukuDigitalController::class, 'index'])->name('buku');
        Route::post('/buku', [BukuDigitalController::class, 'store'])->name('buku.store');
        Route::put('/buku/{id}', [BukuDigitalController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{id}', [BukuDigitalController::class, 'destroy'])->name('buku.destroy');
        Route::get('/buku/{id}/baca', [BukuDigitalController::class, 'baca'])->name('buku.baca');
    });

    // === ROUTE PETUGAS ===
    Route::prefix('petugas')->name('petugas.')->group(function () {
        Route::get('/buku', [BukuDigitalController::class, 'index'])->name('buku');
        Route::post('/buku', [BukuDigitalController::class, 'store'])->name('buku.store');
        Route::put('/buku/{id}', [BukuDigitalController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{id}', [BukuDigitalController::class, 'destroy'])->name('buku.destroy');
        Route::get('/buku/{id}/baca', [BukuDigitalController::class, 'baca'])->name('buku.baca');
    });

    // === ROUTE SISWA (Hanya Read & Baca) ===
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/buku', [BukuDigitalController::class, 'index'])->name('buku');
        Route::get('/buku/{id}/baca', [BukuDigitalController::class, 'baca'])->name('buku.baca');
    });

});