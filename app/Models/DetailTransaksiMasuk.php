<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksiMasuk extends Model
{
    protected $table = 'detail_transaksi_masuk';
    protected $primaryKey = 'id_detail_masuk';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; // Sesuai migration (tanpa timestamps)

    protected $fillable = ['id_detail_masuk', 'id_transaksi_masuk', 'id_produk', 'jumlah_barang', 'harga_satuan', 'total_harga'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}