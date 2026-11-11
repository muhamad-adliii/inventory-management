<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Akun extends Authenticatable
{

    use HasFactory, Notifiable;

    protected $table = 'akun';
    protected $primaryKey = 'id_akun';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_akun',
        'nama',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];
    /**
     * Cek apakah user adalah super admin
     */
    public function isSuperadmin(): bool
    {
        // Perhatikan: sesuaikan dengan string role yang lo pakai di database
        // Kalau di migration pakai 'superadmin' (tanpa underscore):
        return $this->role === 'superadmin';
        
        // ATAU kalau lo ikut rekomendasi gw tadi pakai 'super_admin':
        // return $this->role === 'super_admin';
    }

    /**
     * Cek apakah user adalah admin biasa
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}