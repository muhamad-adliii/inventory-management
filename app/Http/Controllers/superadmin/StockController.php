<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\StockLog;
use App\Models\Barang;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = StockLog::with('barang')->latest();

        // Filter berdasarkan barang
        if ($request->filled('id_barang')) {
            $query->where('id_barang', $request->id_barang);
        }

        // Filter berdasarkan jenis transaksi
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter tanggal awal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }

        // Filter tanggal akhir
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $stockLogs = $query->paginate(10)->withQueryString();
        $barangs = Barang::orderBy('nama_barang')->get();

        return view('dashboard.superadmin.stock', compact(
            'stockLogs',
            'barangs'
        ));
    }
}