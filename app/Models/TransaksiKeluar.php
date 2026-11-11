<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKeluar extends Model
{
    protected $table = 'transaksi_keluar';
    protected $primaryKey = 'id_transaksi_keluar';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_transaksi_keluar', 'tanggal', 'no_invoice', 'keterangan', 'id_customer', 'id_akun'];

    public function detail()
    {
        return $this->hasMany(DetailTransaksiKeluar::class, 'id_transaksi_keluar', 'id_transaksi_keluar');
    }
}