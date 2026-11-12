<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\superadmin\BarangMasukController;
use App\Http\Controllers\superadmin\KategoriController;
use App\Http\Controllers\superadmin\PenjualanController;
use App\Http\Controllers\Superadmin\ProdukController;
use App\Http\Controllers\Superadmin\SupplierController;
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
    Route::get('/kategori', [KategoriController::class, 'index'])->name('superadmin.kategori');
    Route::get('/produk', [ProdukController::class, 'index'])->name('superadmin.produk');
    Route::view('/barang_masuk', 'dashboard.superadmin.barang_masuk')->name('superadmin.barang_masuk');
    Route::view('/penjualan', 'dashboard.superadmin.penjualan')->name('superadmin.penjualan');
    Route::view('/customer', 'dashboard.superadmin.customer')->name('superadmin.customer');
    Route::view('/laporan', 'dashboard.superadmin.laporan')->name('superadmin.laporan');
    Route::view('/supplier', 'dashboard.superadmin.supplier')->name('superadmin.supplier');
    Route::view('/aktivitas', 'dashboard.superadmin.log_aktivitas')->name('superadmin.aktivitas');
    Route::view('/stock', 'dashboard.superadmin.stock')->name('superadmin.stock');
    Route::view('/akun', 'dashboard.superadmin.akun')->name('superadmin.akun');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'dashboard.admin.dashboard')->name('dashboard');
    Route::view('/kategori', 'dashboard.admin.kategori')->name('kategori');
    Route::view('/barang_masuk', 'dashboard.admin.barang_masuk')->name('barang_masuk');
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
    Route::view('/laporan', 'dashboard.admin.laporan')->name('laporan');
    Route::view('/penjualan', 'dashboard.admin.penjualan')->name('penjualan');
});

Route::middleware(['auth', 'role:superadmin,admin'])->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('penjualan', PenjualanController::class)->except(['index']);
    Route::resource('produk', ProdukController::class)->except(['index']);
    Route::resource('barang_masuk', BarangMasukController::class)->except(['index']);
    Route::resource('supplier', SupplierController::class);
});