<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PenjualanController extends Controller
{
    public function index()
    {
        $barang = Barang::all();

        $penjualan = Penjualan::with('detailPenjualan')
            ->latest()
            ->get();

        return view(
            'dashboard.superadmin.penjualan',
            compact('barang', 'penjualan')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_barang' => 'required|array|min:1',
            'id_barang.*' => 'required|exists:barang,id',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'bayar' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {

            $items = [];
            $totalHarga = 0;
            $totalQty = 0;

            foreach ($validated['id_barang'] as $key => $barangId) {

                $barang = Barang::whereKey($barangId)
                    ->lockForUpdate()
                    ->firstOrFail();

                $qty = $validated['qty'][$key];

                if ($barang->stock < $qty) {
                    throw ValidationException::withMessages([
                        'stock' => 'Stok ' . $barang->nama_barang
                            . ' tidak mencukupi.',
                    ]);
                }

                $subtotal = $barang->harga_jual * $qty;

                $items[] = [
                    'barang' => $barang,
                    'qty' => $qty,
                    'harga' => $barang->harga_jual,
                    'subtotal' => $subtotal,
                ];

                $totalHarga += $subtotal;
                $totalQty += $qty;
            }

            if ($validated['bayar'] < $totalHarga) {
                throw ValidationException::withMessages([
                    'bayar' => 'Jumlah pembayaran kurang dari total transaksi.',
                ]);
            }

            $penjualan = Penjualan::create([
                'kode_penjualan' => 'PJ-' . Str::upper(Str::random(10)),
                'tanggal' => now(),
                'total_item' => count($items),
                'total_qty' => $totalQty,
                'total_harga' => $totalHarga,
                'bayar' => $validated['bayar'],
                'kembalian' => $validated['bayar'] - $totalHarga,
            ]);

            foreach ($items as $item) {

                $barang = $item['barang'];
                $qty = $item['qty'];
                $stockSebelum = $barang->stock;

                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id,
                    'id_barang' => $barang->id,
                    'qty' => $qty,
                    'harga' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                ]);

                $barang->decrement('stock', $qty);

                StockLog::create([
                    'id_barang' => $barang->id,
                    'jenis' => 'Penjualan',
                    'qty' => $qty,
                    'stock_sebelum' => $stockSebelum,
                    'stock_sesudah' => $stockSebelum - $qty,
                    'keterangan' => 'Transaksi penjualan: '
                        . $penjualan->kode_penjualan,
                ]);
            }
        });

        return redirect()->back()
            ->with('success', 'Transaksi berhasil');
    }
}