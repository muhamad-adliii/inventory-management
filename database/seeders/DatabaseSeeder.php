<?php

namespace Database\Seeders;

use App\Models\Akun;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== AKUN =====
        Akun::create([
            'id_akun'  => 'SADM001',
            'nama'     => 'Super Admin',
            'username' => 'superadmin123',
            'password' => Hash::make('superadmin123'),
            'role'     => 'superadmin',  
        ]);

        Akun::create([
            'id_akun'  => 'ADM001',
            'nama'     => 'Admin',
            'username' => 'admin123',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // ===== KATEGORI =====
        Kategori::create(['id_kategori' => 'KAT001', 'nama_kategori' => 'Minuman']);
        Kategori::create(['id_kategori' => 'KAT002', 'nama_kategori' => 'Makanan']);
        Kategori::create(['id_kategori' => 'KAT003', 'nama_kategori' => 'Alat Tulis']);

        // ===== SUPPLIER =====
        Supplier::create([
            'id_supplier'   => 'SUP001',
            'nama_supplier' => 'PT Sumber Makmur',
            'alamat'        => 'Jl. Merdeka No. 1, Jakarta',
            'no_hp'         => '0211234567',
            'email'         => 'sumber@makmur.com',
        ]);
        Supplier::create([
            'id_supplier'   => 'SUP002',
            'nama_supplier' => 'CV Berkah Jaya',
            'alamat'        => 'Jl. Sudirman No. 2, Bandung',
            'no_hp'         => '0227654321',
            'email'         => 'berkah@jaya.com',
        ]);

        // ===== CUSTOMER =====
        Customer::create([
            'id_customer' => 'CUS001',
            'nama'        => 'Toko Sejahtera',
            'alamat'      => 'Jl. Pasar Baru No. 10',
            'no_telp'     => '081234567890',
        ]);
        Customer::create([
            'id_customer' => 'CUS002',
            'nama'        => 'Warung Bu Siti',
            'alamat'      => 'Jl. Kampung Baru No. 5',
            'no_telp'     => '081298765432',
        ]);

        // ===== PRODUK =====
        Produk::create([
            'id_produk'   => 'PRD001',
            'nama_produk' => 'Teh Botol Sosro 350ml',
            'harga'       => 5000,
            'stok'        => 0,
            'satuan'      => 'pcs',
            'deskripsi'   => 'Teh botol kemasan 350ml',
            'id_kategori' => 'KAT001',
            'id_supplier' => 'SUP001',
        ]);
        Produk::create([
            'id_produk'   => 'PRD002',
            'nama_produk' => 'Indomie Goreng',
            'harga'       => 3500,
            'stok'        => 0,
            'satuan'      => 'pcs',
            'deskripsi'   => 'Mie instan goreng',
            'id_kategori' => 'KAT002',
            'id_supplier' => 'SUP002',
        ]);
    }
}