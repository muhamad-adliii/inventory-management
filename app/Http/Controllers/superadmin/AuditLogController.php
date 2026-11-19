<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $auditLog = AuditLog::with('akun')
            ->when($request->aksi, fn($q, $v) => $q->where('aksi', $v))
            ->when($request->entitas, fn($q, $v) => $q->where('entitas', $v))
            ->when($request->tanggal_awal, fn($q, $v) => $q->whereDate('tanggal', '>=', $v))
            ->when($request->tanggal_akhir, fn($q, $v) => $q->whereDate('tanggal', '<=', $v))
            ->when($request->q, fn($q, $v) => $q->where(function ($w) use ($v) {
                $w->where('id_referensi', 'like', "%$v%")
                    ->orWhere('nama_referensi', 'like', "%$v%")
                    ->orWhere('detail', 'like', "%$v%");
            }))
            ->orderByDesc('tanggal')
            ->orderByDesc('id_log')
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.superadmin.log_aktivitas', compact('auditLog'));
    }
}
