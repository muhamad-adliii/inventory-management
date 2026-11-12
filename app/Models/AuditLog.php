<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_log';
    protected $primaryKey = 'id_log';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_log',
        'tanggal',
        'aksi',
        'entitas',
        'id_referensi',
        'nama_referensi',
        'detail',
        'id_akun',
    ];

    protected function casts(): array
    {
        return ['tanggal' => 'datetime'];
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }
}