<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\superadmin\BarangController;
use App\Http\Controllers\superadmin\BarangMasukController;
use App\Http\Controllers\superadmin\KategoriController;
use App\Http\Controllers\superadmin\PenjualanController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::view('/', 'dashboard.superadmin.dashboard')->name('superadmin.dashboard');
    Route::view('/kategori', 'dashboard.superadmin.kategori')->name('superadmin.kategori');
    Route::view('/data_barang', 'dashboard.superadmin.data_barang')->name('superadmin.barang');
    Route::view('/barang_masuk', 'dashboard.superadmin.barang_masuk')->name('superadmin.barang_masuk');
    Route::view('/penjualan', 'dashboard.superadmin.penjualan')->name('superadmin.penjualan');
    Route::view('/laporan', 'dashboard.superadmin.laporan')->name('superadmin.laporan');
    Route::view('/aktivitas', 'dashboard.superadmin.log_aktivitas')->name('superadmin.aktivitas');
    Route::view('/stock', 'dashboard.superadmin.stock')->name('superadmin.stock');
    Route::view('/akun', 'dashboard.superadmin.akun')->name('superadmin.akun');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'dashboard.admin.dashboard')->name('dashboard');
    Route::view('/kategori', 'dashboard.admin.kategori')->name('kategori');
    Route::view('/barang_masuk', 'dashboard.admin.barang_masuk')->name('barang_masuk');
    Route::view('/barang', 'dashboard.admin.barang')->name('barang');
    Route::view('/laporan', 'dashboard.admin.laporan')->name('laporan');
    Route::view('/penjualan', 'dashboard.admin.penjualan')->name('penjualan');
});

Route::middleware(['auth', 'role:superadmin,admin'])->group(function () {
    Route::resource('kategori', KategoriController::class)->except(['index']);
    Route::resource('penjualan', PenjualanController::class)->except(['index']);
    Route::resource('barang', BarangController::class)->except(['index']);
    Route::resource('barang_masuk', BarangMasukController::class)->except(['index']);
});