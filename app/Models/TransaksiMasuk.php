<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiMasuk extends Model
{
    protected $table = 'transaksi_masuk';
    protected $primaryKey = 'id_transaksi_masuk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_transaksi_masuk', 'tanggal', 'no_invoice', 'keterangan', 'id_supplier', 'id_akun'];

    public function detail()
    {
        return $this->hasMany(DetailTransaksiMasuk::class, 'id_transaksi_masuk', 'id_transaksi_masuk');
    }
}