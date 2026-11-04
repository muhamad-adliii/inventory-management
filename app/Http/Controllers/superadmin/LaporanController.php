<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $query = Penjualan::query();

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        $laporan = $query->latest('tanggal')->paginate(10)->withQueryString();

        $totalTransaksi = (clone $query)->count();
        $totalPendapatan = (clone $query)->sum('total_harga');

        return view('dashboard.superadmin.laporan', compact(
            'laporan',
            'totalTransaksi',
            'totalPendapatan'
        ));
    }
}