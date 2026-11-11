<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Akun extends Authenticatable
{
    use Notifiable;
    protected $table = 'akun';
    protected $primaryKey = 'id_akun';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_akun', 'nama', 'username', 'password', 'role'];

    protected $hidden = ['password'];

    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}