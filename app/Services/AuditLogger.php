<?php

namespace App\Services;

use App\Helpers\IdGenerator;
use App\Models\AuditLog;

class AuditLogger
{
    public static function catat(
        string $aksi,
        string $entitas,
        string $idReferensi,
        ?string $nama = null,
        ?string $detail = null
    ): void {
        AuditLog::create([
            'id_log' => IdGenerator::buat('audit_log', 'id_log', 'LOG', 5),
            'tanggal' => now(),
            'aksi' => $aksi,
            'entitas' => $entitas,
            'id_referensi' => $idReferensi,
            'nama_referensi' => $nama,
            'detail' => $detail,
            'id_akun' => auth()->user()->id_akun,
        ]);
    }
}