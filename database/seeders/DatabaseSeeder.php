<?php

namespace Database\Seeders;

use App\Models\Akun;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Akun::create([
            'id_akun' => 'SADM001',
            'nama' => 'Super Admin',
            'username' => 'superadmin123',
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
        ]);

        Akun::create([
            'id_akun' => 'ADM001',
            'nama' => 'Admin',
            'username' => 'admin123',
            'password' => HASH::make('admin123'),
            'role' => 'admin',
        ]);
    }
}
