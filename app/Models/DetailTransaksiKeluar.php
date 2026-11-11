<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksiKeluar extends Model
{
    protected $table = 'detail_transaksi_keluar';
    protected $primaryKey = 'id_detail_keluar';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_detail_keluar', 'id_transaksi_keluar', 'id_produk', 'jumlah_barang', 'harga_satuan', 'total_harga'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}