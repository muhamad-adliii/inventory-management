<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Produk;
use App\Models\TransaksiMasuk;
use App\Models\DetailTransaksiMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = TransaksiMasuk::with(['supplier', 'akun', 'detailTransaksiMasuk.produk'])
            ->orderBy('id_transaksi_masuk', 'desc')
            ->get();

        $supplier = Supplier::orderBy('nama_supplier')->get();
        $produk = Produk::orderBy('nama_produk')->get();

        $view = auth()->user()->role === 'admin'
            ? 'dashboard.admin.barang_masuk'
            : 'dashboard.superadmin.barang_masuk';

        return view($view, compact('barangMasuk', 'supplier', 'produk'));
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'id_supplier' => 'required|exists:supplier,id_supplier',
    //         'no_invoice' => 'nullable|string|max:50',
    //     ]);

    //     DB::transaction(function () use ($validated) {
    //         TransaksiMasuk::create([
    //             'id_transaksi_masuk' => IdGenerator::buat('transaksi_masuk', 'id_transaksi_masuk', 'BM'),
    //             'tanggal' => now(),
    //             'no_invoice' => $validated['no_invoice'] ?? null,
    //             'id_supplier' => $validated['id_supplier'],
    //             'id_akun' => auth()->user()->id_akun,
    //         ]);
    //     });

    //     return redirect()->back()->with('success', 'Nota barang masuk berhasil dibuat');
    // }
    public function store(Request $request)
    {
        // 1. Validasi Header & Detail
        $validated = $request->validate([
            'id_supplier' => 'required|exists:supplier,id_supplier',
            'no_invoice'  => 'nullable|string|max:50',
            // Validasi array items
            'items'               => 'required|array|min:1',
            'items.*.id_produk'   => 'required|exists:produk,id_produk',
            'items.*.qty'         => 'required|integer|min:1',
            'items.*.harga'       => 'required|numeric|min:0',
        ], [
            'items.required' => 'Minimal tambahkan 1 produk ke dalam daftar.',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // 2. Simpan Header Transaksi
                $idTransaksi = IdGenerator::buat('transaksi_masuk', 'id_transaksi_masuk', 'BM');
                
                TransaksiMasuk::create([
                    'id_transaksi_masuk' => $idTransaksi,
                    'tanggal'            => now(),
                    'no_invoice'         => $validated['no_invoice'] ?? null,
                    'id_supplier'        => $validated['id_supplier'],
                    'id_akun'            => auth()->user()->id_akun,
                ]);

                // 3. Simpan Detail Transaksi (Looping)
                foreach ($validated['items'] as $item) {
                    DetailTransaksiMasuk::create([
                        'id_detail_masuk'    => IdGenerator::buat('detail_transaksi_masuk', 'id_detail_masuk', 'DTM'),
                        'id_transaksi_masuk' => $idTransaksi,
                        'id_produk'          => $item['id_produk'],
                        'jumlah_barang'      => $item['qty'],
                        'harga_satuan'       => $item['harga'],
                        'total_harga'        => $item['qty'] * $item['harga'],
                    ]);

                    // OPSIONAL: Jika ingin stok produk langsung bertambah
                    // Produk::where('id_produk', $item['id_produk'])->increment('stok', $item['qty']);
                }
            });

            return redirect()->back()->with('success', 'Transaksi barang masuk berhasil disimpan');

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

        $transaksi->update($validated);

        return redirect()->back()->with('success', 'Nota barang masuk berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $transaksi = TransaksiMasuk::findOrFail($id);
        $transaksi->delete();

        return redirect()->back()->with('success', 'Nota barang masuk berhasil dihapus');
    }
    public function getDetail(string $id)
    {
        // Ambil data transaksi beserta relasi produk dan akun
        $transaksi = TransaksiMasuk::with(['supplier', 'akun', 'detailTransaksiMasuk.produk'])
            ->findOrFail($id);

        return response()->json($transaksi);
    }
}