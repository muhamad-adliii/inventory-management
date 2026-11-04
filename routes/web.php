<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\superadmin\BarangController;
use App\Http\Controllers\superadmin\BarangMasukController;
use App\Http\Controllers\superadmin\KategoriController;
use App\Http\Controllers\superadmin\PenjualanController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::view('/', 'dashboard/superadmin/dashboard');
    Route::view('/kategori', 'dashboard/superadmin/kategori');
    Route::view('/data_barang', 'dashboard/superadmin/data_barang');
    Route::view('/barang_masuk', 'dashboard/superadmin/barang_masuk');
    Route::view('/penjualan', 'dashboard/superadmin/penjualan');
    Route::view('/laporan', 'dashboard/superadmin/laporan');
    Route::view('/aktivitas', 'dashboard/superadmin/log_aktivitas');
    Route::view('/stock', 'dashboard/superadmin/stock');
    Route::view('/akun', 'dashboard/superadmin/akun');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::view('/dashboard', 'dashboard/admin/dashboard');
    Route::view('/kategori', 'dashboard/admin/kategori');
    Route::view('/barang_masuk', 'dashboard/admin/barang_masuk');
    Route::view('/barang', 'dashboard/admin/barang');
    Route::view('/laporan', 'dashboard/admin/laporan');
    Route::view('/penjualan', 'dashboard/admin/penjualan');
});

Route::middleware(['auth', 'role:superadmin,admin'])->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('penjualan', PenjualanController::class)->except(['index']);
    Route::resource('barang', BarangController::class);
    Route::resource('barang-masuk', BarangMasukController::class);
});