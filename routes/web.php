<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\superadmin\BarangMasukController;
use App\Http\Controllers\superadmin\AuditLogController;
use App\Http\Controllers\superadmin\LaporanController;
use App\Http\Controllers\superadmin\AccountController;
use App\Http\Controllers\superadmin\CustomerController;
use App\Http\Controllers\superadmin\KategoriController;
use App\Http\Controllers\superadmin\PenjualanController;
use App\Http\Controllers\superadmin\ProdukController;
use App\Http\Controllers\superadmin\SupplierController;
use App\Http\Controllers\superadmin\DashboardController;
use App\Http\Controllers\superadmin\ReturController;
use App\Http\Controllers\superadmin\TransaksiKeluarController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('superadmin.kategori');
    Route::get('/produk', [ProdukController::class, 'index'])->name('superadmin.produk');
    Route::get('/barang_masuk', [BarangMasukController::class, 'index'])->name('superadmin.barang_masuk');
    // Route::get('/barang-masuk/{id}/detail', [BarangMasukController::class, 'getDetail'])->name('barang_masuk.detail');
    Route::view('/penjualan', 'dashboard.superadmin.penjualan')->name('superadmin.penjualan');
    // Route::view('/customer', 'dashboard.superadmin.customer')->name('superadmin.customer');
    // Route::view('/laporan', 'dashboard.superadmin.laporan')->name('superadmin.laporan');
    Route::view('/supplier', 'dashboard.superadmin.supplier')->name('superadmin.supplier');
    Route::get('/aktivitas', [AuditLogController::class, 'index'])->name('superadmin.log_aktivitas');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('superadmin.laporan');
    Route::view('/stock', 'dashboard.superadmin.stock')->name('superadmin.stock');
    Route::resource('akun', AccountController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::patch('/retur/{id}/status', [ReturController::class, 'updateStatus'])->name('retur.update_status');
    Route::get('/retur', [ReturController::class, 'index'])->name('superadmin.retur');
    Route::get('/retur/transaksi/{id}', [ReturController::class, 'getTransaksiDetail'])->name('retur.get_transaksi');
    Route::resource('retur', ReturController::class)->only(['store']);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'dashboard.admin.dashboard')->name('dashboard');
    Route::view('/kategori', 'dashboard.admin.kategori')->name('kategori');
    Route::view('/retur', 'dashboard.admin.retur')->name('retur');
    Route::get('/barang_masuk', [BarangMasukController::class, 'index'])->name('admin.barang_masuk');
    // Route::get('/barang-masuk/{id}/detail', [BarangMasukController::class, 'getDetail'])->name('barang_masuk.detail');
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    // Route::view('/transaksi_keluar', 'dashboard.admin.transaksi_keluar')->name('transaksi_keluar');
});

Route::middleware(['auth', 'role:superadmin,admin'])->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('penjualan', PenjualanController::class)->except(['index']);
    Route::resource('produk', ProdukController::class)->except(['index']);
    Route::resource('barang_masuk', BarangMasukController::class)->only(['store', 'update', 'destroy']);
    Route::get('/barang-masuk/{id}/detail', [BarangMasukController::class, 'getDetail'])
        ->name('barang_masuk.detail');
    Route::resource('supplier', SupplierController::class);
    Route::resource('customer', CustomerController::class);
    Route::get('/transaksi_keluar', [TransaksiKeluarController::class, 'index'])->name('superadmin.transaksi_keluar');
    Route::get('/transaksi-keluar/{id}/detail', [TransaksiKeluarController::class, 'getDetail'])->name('transaksi_keluar.detail');
    Route::resource('transaksi_keluar', TransaksiKeluarController::class)->only(['store', 'update', 'destroy']);
    Route::get('/retur', [ReturController::class, 'index'])->name('superadmin.retur');
    Route::get('/retur/transaksi/{id}', [ReturController::class, 'getTransaksiDetail'])->name('retur.get_transaksi');
    Route::resource('retur', ReturController::class)->only(['store']);
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
    Route::put('/pengaturan/profil', [PengaturanController::class, 'updateProfil'])->name('pengaturan.profil');
    Route::put('/pengaturan/password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.password');
});