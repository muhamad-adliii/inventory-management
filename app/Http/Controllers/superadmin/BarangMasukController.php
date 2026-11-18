<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Produk;
use App\Models\TransaksiMasuk;
use App\Models\DetailTransaksiMasuk;
use App\Services\AuditLogger; // <-- Tambahan Import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = TransaksiMasuk::with(['supplier', 'akun', 'detailTransaksiMasuk.produk'])
            ->orderBy('id_transaksi_masuk', 'asc')
            ->get();

        $supplier = Supplier::orderBy('nama_supplier')->get();
        $produk = Produk::orderBy('nama_produk')->get();

        $view = auth()->user()->role === 'admin'
            ? 'dashboard.admin.barang_masuk'
            : 'dashboard.superadmin.barang_masuk';

        return view($view, compact('barangMasuk', 'supplier', 'produk'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_supplier' => 'required|exists:supplier,id_supplier',
            'no_invoice' => 'nullable|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.id_produk' => 'required|exists:produk,id_produk',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $idTransaksi = IdGenerator::buat('transaksi_masuk', 'id_transaksi_masuk', 'BM');
                
                $transaksi = TransaksiMasuk::create([
                    'id_transaksi_masuk' => $idTransaksi,
                    'tanggal' => now(),
                    'no_invoice' => $validated['no_invoice'] ?? null,
                    'id_supplier' => $validated['id_supplier'],
                    'id_akun' => auth()->user()->id_akun,
                ]);

                $ringkasanBarang = []; // Array untuk nyatet nama barang di log

                foreach ($validated['items'] as $item) {
                    DetailTransaksiMasuk::create([
                        'id_detail_masuk' => IdGenerator::buat('detail_transaksi_masuk', 'id_detail_masuk', 'DTM'),
                        'id_transaksi_masuk' => $idTransaksi,
                        'id_produk' => $item['id_produk'],
                        'jumlah_barang' => $item['qty'],
                        'harga_satuan' => $item['harga'],
                        'total_harga' => $item['qty'] * $item['harga'],
                    ]);

                    Produk::where('id_produk', $item['id_produk'])->increment('stok', $item['qty']);

                    // Ambil nama produk buat log
                    $namaProduk = Produk::where('id_produk', $item['id_produk'])->value('nama_produk');
                    $ringkasanBarang[] = "{$namaProduk} ({$item['qty']})";
                }

                // TAMBAHKAN AUDIT LOGGER
                $detailLog = implode(', ', $ringkasanBarang);
                AuditLogger::catat(
                    'transaksi_masuk',
                    'transaksi_masuk',
                    $idTransaksi,
                    $idTransaksi,
                    "Input transaksi masuk. Barang: {$detailLog}"
                );
            });

            return redirect()->back()->with('success', 'Transaksi barang masuk berhasil disimpan & stok diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $transaksi = TransaksiMasuk::findOrFail($id);

        $validated = $request->validate([
            'id_supplier' => 'required|exists:supplier,id_supplier',
            'no_invoice' => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($transaksi, $validated) {
            $transaksi->update($validated);

            // TAMBAHKAN AUDIT LOGGER UNTUK EDIT
            AuditLogger::catat(
                'edit_transaksi_masuk',
                'transaksi_masuk',
                $transaksi->id_transaksi_masuk,
                $transaksi->id_transaksi_masuk,
                "Memperbarui header nota transaksi masuk {$transaksi->id_transaksi_masuk}"
            );
        });

        return redirect()->back()->with('success', 'Nota barang masuk berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $transaksi = TransaksiMasuk::with('detailTransaksiMasuk')->findOrFail($id);
                
                $ringkasanBarang = [];

                foreach ($transaksi->detailTransaksiMasuk as $detail) {
                    Produk::where('id_produk', $detail->id_produk)->decrement('stok', $detail->jumlah_barang);
                    
                    // Ambil nama produk buat log
                    $namaProduk = Produk::where('id_produk', $detail->id_produk)->value('nama_produk');
                    $ringkasanBarang[] = "{$namaProduk} ({$detail->jumlah_barang})";
                }

                $transaksi->delete();

                // TAMBAHKAN AUDIT LOGGER UNTUK HAPUS
                $detailLog = implode(', ', $ringkasanBarang);
                AuditLogger::catat(
                    'hapus_transaksi_masuk',
                    'transaksi_masuk',
                    $id,
                    $id,
                    "Menghapus transaksi masuk (Stok dikurangi). Barang: {$detailLog}"
                );
            });

            return redirect()->back()->with('success', 'Transaksi berhasil dihapus & stok telah dikoreksi');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    public function getDetail(string $id)
    {
        $transaksi = TransaksiMasuk::with(['supplier', 'akun', 'detailTransaksiMasuk.produk'])->findOrFail($id);
        return response()->json($transaksi);
    }
}