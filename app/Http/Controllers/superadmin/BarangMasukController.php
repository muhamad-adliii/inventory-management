<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\DetailBarangMasuk;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('detailBarangMasuk')
            ->latest()
            ->get();

        $barang = Barang::all();

        return view(
            'dashboard.superadmin.barang_masuk',
            compact('barangMasuk', 'barang')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier' => 'required|string|max:255',
            'id_barang' => 'required|array|min:1',
            'id_barang.*' => 'required|exists:barang,id',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {

            $barangMasuk = BarangMasuk::create([
                'kode_transaksi' => 'BM-' . Str::upper(Str::random(10)),
                'tanggal' => now(),
                'supplier' => $validated['supplier'],
                'total_item' => count($validated['id_barang']),
                'total_qty' => array_sum($validated['qty']),
                'total_harga' => 0,
            ]);

            $totalHarga = 0;

            foreach ($validated['id_barang'] as $key => $barangId) {

                $barang = Barang::whereKey($barangId)
                    ->lockForUpdate()
                    ->firstOrFail();

                $qty = $validated['qty'][$key];
                $harga = $validated['harga'][$key];
                $subtotal = $qty * $harga;

                DetailBarangMasuk::create([
                    'id_barang_masuk' => $barangMasuk->id,
                    'id_barang' => $barang->id,
                    'qty' => $qty,
                    'harga' => $harga,
                    'subtotal' => $subtotal,
                ]);

                $stockSebelum = $barang->stock;

                $barang->increment('stock', $qty);

                StockLog::create([
                    'id_barang' => $barang->id,
                    'jenis' => 'Barang Masuk',
                    'qty' => $qty,
                    'stock_sebelum' => $stockSebelum,
                    'stock_sesudah' => $stockSebelum + $qty,
                    'keterangan' => 'Transaksi barang masuk: '
                        . $barangMasuk->kode_transaksi,
                ]);

                $totalHarga += $subtotal;
            }

            $barangMasuk->update([
                'total_harga' => $totalHarga,
            ]);
        });

        return redirect()->back()
            ->with('success', 'Barang masuk berhasil ditambahkan');
    }
}