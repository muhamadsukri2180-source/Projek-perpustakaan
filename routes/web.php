<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SiswaController;

Route::get('/', [AuthController::class, 'index'])->name('portal');
Route::get('/login/{role}', [AuthController::class, 'loginRole'])->name('login.role');
Route::post('/login/{role}', [AuthController::class, 'authenticate'])->name('login.perform');
Route::post('/login-scan', [AuthController::class, 'loginByBarcode'])->name('login.scan');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // --- SISWA ---
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::get('/siswa/list', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

    Route::get('/kelas', [AdminController::class, 'kelasIndex'])->name('kelas.index');
    Route::get('/jurusan', [AdminController::class, 'jurusanIndex'])->name('jurusan.index');

    // --- KELOLA PETUGAS (oleh Admin, via AdminController) ---
    Route::get('/petugas', [AdminController::class, 'petugasIndex'])->name('petugas.index');
    Route::post('/petugas', [AdminController::class, 'petugasStore'])->name('petugas.store');
    Route::delete('/petugas/{id}', [AdminController::class, 'petugasDestroy'])->name('petugas.destroy');

    // Barcode Petugas
    Route::get('/petugas/barcode', [AdminController::class, 'petugasBarcodeGenerate'])->name('petugas.barcode.generate');
    Route::get('/petugas/barcode/{id}/download', [AdminController::class, 'petugasBarcodeDownload'])->name('petugas.barcode.download');

    // --- PRESENSI ---
    Route::get('/presensi', [AdminController::class, 'presensiIndex'])->name('presensi');
    Route::post('/presensi/scan', [AdminController::class, 'presensiScan'])->name('presensi.scan');

    // --- LAPORAN ---
    Route::get('/laporan', [AdminController::class, 'laporanIndex'])->name('laporan');
    Route::get('/laporan/index', [AdminController::class, 'laporanIndex'])->name('laporan.index');
    Route::get('/laporan/harian', [AdminController::class, 'laporanHarian'])->name('laporan.harian');
    Route::get('/laporan/mingguan', [AdminController::class, 'laporanMingguan'])->name('laporan.mingguan');
    Route::get('/laporan/bulanan', [AdminController::class, 'laporanBulanan'])->name('laporan.bulanan');
    Route::get('/laporan/tahunan', [AdminController::class, 'laporanTahunan'])->name('laporan.tahunan');

    // --- BARCODE SISWA ---
    Route::get('/barcode/generate', [AdminController::class, 'barcodeGenerate'])->name('barcode.generate');
    Route::get('/barcode/download/{id}', [AdminController::class, 'barcodeDownload'])->name('barcode.download');
    Route::get('/statistik/pengunjung', [AdminController::class, 'statistikPengunjung'])->name('statistik.pengunjung');

    // --- PROFIL ADMIN ---
    Route::get('/profile', [AdminController::class, 'profileIndex'])->name('profile');
    Route::put('/profile/update', [AdminController::class, 'profileUpdate'])->name('profile.update');
    Route::put('/profile/password', [AdminController::class, 'profilePassword'])->name('profile.password');
});

Route::prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PetugasController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [PetugasController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [PetugasController::class, 'updatePassword'])->name('profile.password');
    Route::get('/scan', [PetugasController::class, 'scanIndex'])->name('scan');
    Route::post('/scan/process', [PetugasController::class, 'scanProcess'])->name('scan.process');
    Route::get('/transaksi', [PetugasController::class, 'transaksiIndex'])->name('transaksi.index');

    Route::get('/siswa', [PetugasController::class, 'siswaIndex'])->name('siswa');
    Route::get('/presensi', [PetugasController::class, 'presensiIndex'])->name('presensi');
    Route::get('/laporan', [PetugasController::class, 'laporanIndex'])->name('laporan');
});

Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/riwayat', [SiswaController::class, 'riwayat'])->name('riwayat');
});

Route::prefix('petugas')->name('petugas.')->middleware('auth:petugas')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
});
Route::prefix('petugas')->name('petugas.')->middleware('auth:petugas')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PetugasController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [PetugasController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [PetugasController::class, 'updatePassword'])->name('profile.password');
    Route::get('/scan', [PetugasController::class, 'scanIndex'])->name('scan');
    Route::post('/scan/process', [PetugasController::class, 'scanProcess'])->name('scan.process');
    Route::get('/transaksi', [PetugasController::class, 'transaksiIndex'])->name('transaksi.index');

    // --- AKSES SISWA UNTUK PETUGAS (Tambah, Lihat, Edit, Hapus) ---
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::get('/siswa/list', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

    Route::get('/presensi', [PetugasController::class, 'presensiIndex'])->name('presensi');
    Route::get('/laporan', [PetugasController::class, 'laporanIndex'])->name('laporan');
});