<?php

namespace App\Enums;

class AksiLog
{
    // Master data — Produk
    public const TAMBAH_PRODUK    = 'TAMBAH_PRODUK';
    public const EDIT_PRODUK      = 'EDIT_PRODUK';
    public const HAPUS_PRODUK     = 'HAPUS_PRODUK';
    // Master data — Kategori
    public const TAMBAH_KATEGORI  = 'TAMBAH_KATEGORI';
    public const EDIT_KATEGORI    = 'EDIT_KATEGORI';
    public const HAPUS_KATEGORI   = 'HAPUS_KATEGORI';
    // Master data — Supplier
    public const TAMBAH_SUPPLIER  = 'TAMBAH_SUPPLIER';
    public const EDIT_SUPPLIER    = 'EDIT_SUPPLIER';
    public const HAPUS_SUPPLIER   = 'HAPUS_SUPPLIER';
    // Master data — Customer
    public const TAMBAH_CUSTOMER  = 'TAMBAH_CUSTOMER';
    public const EDIT_CUSTOMER    = 'EDIT_CUSTOMER';
    public const HAPUS_CUSTOMER   = 'HAPUS_CUSTOMER';
    // Akun
    public const TAMBAH_AKUN      = 'TAMBAH_AKUN';
    public const HAPUS_AKUN       = 'HAPUS_AKUN';
    // Transaksi
    public const TRANSAKSI_MASUK  = 'TRANSAKSI_MASUK';
    public const TRANSAKSI_KELUAR = 'TRANSAKSI_KELUAR';
    // Retur
    public const RETUR            = 'RETUR';
    public const APPROVE_RETUR    = 'APPROVE_RETUR';
    public const REJECT_RETUR     = 'REJECT_RETUR';
    // Autentikasi (opsional)
    public const LOGIN            = 'LOGIN';
    public const LOGOUT           = 'LOGOUT';

    public static function all(): array
    {
        return [
            self::TAMBAH_PRODUK, self::EDIT_PRODUK, self::HAPUS_PRODUK,
            self::TAMBAH_KATEGORI, self::EDIT_KATEGORI, self::HAPUS_KATEGORI,
            self::TAMBAH_SUPPLIER, self::EDIT_SUPPLIER, self::HAPUS_SUPPLIER,
            self::TAMBAH_CUSTOMER, self::EDIT_CUSTOMER, self::HAPUS_CUSTOMER,
            self::TAMBAH_AKUN, self::HAPUS_AKUN,
            self::TRANSAKSI_MASUK, self::TRANSAKSI_KELUAR,
            self::RETUR, self::APPROVE_RETUR, self::REJECT_RETUR,
            self::LOGIN, self::LOGOUT,
        ];
    }
}