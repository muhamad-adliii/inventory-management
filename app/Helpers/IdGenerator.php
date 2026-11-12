<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class IdGenerator
{
    /**
     * @param string $table   
     * @param string $kolom  
     * @param string $prefix  
     * @param int    $panjang 
     */
    public static function buat(string $table, string $kolom, string $prefix, int $panjang = 3): string
    {
        $terakhir = DB::table($table)
            ->where($kolom, 'like', $prefix . '%')
            ->lockForUpdate()
            ->orderByRaw("CAST(SUBSTRING($kolom, ?) AS UNSIGNED) DESC", [strlen($prefix) + 1])
            ->value($kolom);

        $nomor = $terakhir ? ((int) substr($terakhir, strlen($prefix))) + 1 : 1;

        return $prefix . str_pad($nomor, $panjang, '0', STR_PAD_LEFT);
    }
}