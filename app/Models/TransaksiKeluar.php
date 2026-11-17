<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransaksiKeluar extends Model
{
    protected $table = 'transaksi_keluar';
    protected $primaryKey = 'id_transaksi_keluar';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_transaksi_keluar', 'tanggal', 'id_customer', 'id_akun'];

    public function customer() { return $this->belongsTo(Customer::class, 'id_customer', 'id_customer'); }
    public function akun() { return $this->belongsTo(Akun::class, 'id_akun', 'id_akun'); }
    public function detailTransaksiKeluar() { return $this->hasMany(DetailTransaksiKeluar::class, 'id_transaksi_keluar', 'id_transaksi_keluar'); }
}
?>










<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class TransaksiKeluar extends Model
// {
//     protected $table = 'transaksi_keluar';
//     protected $primaryKey = 'id_transaksi_keluar';
//     public $incrementing = false;
//     protected $keyType = 'string';

//     protected $fillable = ['id_transaksi_keluar', 'tanggal', 'no_invoice', 'keterangan', 'id_customer', 'id_akun'];

//     public function detail()
//     {
//         return $this->hasMany(DetailTransaksiKeluar::class, 'id_transaksi_keluar', 'id_transaksi_keluar');
//     }
// }
?>