<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiMasuk extends Model
{
    protected $table = 'transaksi_masuk';
    protected $primaryKey = 'id_transaksi_masuk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_transaksi_masuk', 'tanggal', 'no_invoice', 'id_supplier', 'id_akun'];

    protected function casts(): array
    {
        return ['tanggal' => 'datetime'];
    }

    // public function detail()
    // {
    //     return $this->hasMany(DetailTransaksiMasuk::class, 'id_transaksi_masuk', 'id_transaksi_masuk');
    // }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }
    public function detailTransaksiMasuk()
    {
        return $this->hasMany(DetailTransaksiMasuk::class, 'id_transaksi_masuk', 'id_transaksi_masuk');
    }
}