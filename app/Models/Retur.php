<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    protected $table = 'retur';
    protected $primaryKey = 'id_retur';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_retur', 'tanggal', 'alasan', 'dokumentasi_path', 'status_retur', 'id_akun'];

    public function detail()
    {
        return $this->hasMany(DetailRetur::class, 'id_retur', 'id_retur');
    }
}