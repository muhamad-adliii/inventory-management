<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailRetur extends Model
{
    protected $table = 'detail_retur';
    protected $primaryKey = 'id_detail_retur';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['id_detail_retur', 'id_retur', 'id_produk', 'id_transaksi_masuk', 'jumlah_retur'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}