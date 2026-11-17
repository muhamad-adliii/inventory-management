<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\TransaksiKeluar;
use App\Models\DetailTransaksiKeluar;
use App\Models\Customer;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiKeluarController extends Controller
{
    public function index()
    {
        $transaksiKeluar = TransaksiKeluar::with(['customer', 'akun', 'detailTransaksiKeluar.produk'])
            ->orderBy('id_transaksi_keluar', 'desc')
            ->get();

        $customer = Customer::orderBy('nama_customer')->get();
        $produk   = Produk::orderBy('nama_produk')->get();

        $view = auth()->user()->role === 'admin'
            ? 'dashboard.admin.transaksi_keluar'
            : 'dashboard.superadmin.transaksi_keluar';

        return view($view, compact('transaksiKeluar', 'customer', 'produk'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_customer' => 'required|exists:customer,id_customer',
            // 'no_invoice'  => 'nullable|string|max:50',
            'items'               => 'required|array|min:1',
            'items.*.id_produk'   => 'required|exists:produk,id_produk',
            'items.*.qty'         => 'required|integer|min:1',
            'items.*.harga'       => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // 1. Cek Stok Terlebih Dahulu
                foreach ($validated['items'] as $item) {
                    $produk = Produk::where('id_produk', $item['id_produk'])->lockForUpdate()->first();
                    if ($produk->stok < $item['qty']) {
                        throw new \Exception("Stok produk {$produk->nama_produk} tidak mencukupi. Sisa: {$produk->stok}");
                    }
                }

                // 2. Simpan Header Transaksi
                $idTransaksi = IdGenerator::buat('transaksi_keluar', 'id_transaksi_keluar', 'BK'); // BK = Barang Keluar
                
                TransaksiKeluar::create([
                    'id_transaksi_keluar' => $idTransaksi,
                    'tanggal'             => now(),
                    // 'no_invoice'          => $validated['no_invoice'] ?? null,
                    'id_customer'         => $validated['id_customer'],
                    'id_akun'             => auth()->user()->id_akun,
                ]);

                // 3. Simpan Detail & Kurangi Stok
                foreach ($validated['items'] as $item) {
                    DetailTransaksiKeluar::create([
                        'id_detail_keluar'    => IdGenerator::buat('detail_transaksi_keluar', 'id_detail_keluar', 'DTK'),
                        'id_transaksi_keluar' => $idTransaksi,
                        'id_produk'           => $item['id_produk'],
                        'jumlah_barang'       => $item['qty'],
                        'harga_satuan'        => $item['harga'],
                        'total_harga'         => $item['qty'] * $item['harga'],
                    ]);

                    // Kurangi Stok
                    Produk::where('id_produk', $item['id_produk'])->decrement('stok', $item['qty']);
                }
            });

            return redirect()->back()->with('success', 'Transaksi keluar berhasil disimpan & stok diperbarui');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $transaksi = TransaksiKeluar::with('detailTransaksiKeluar')->findOrFail($id);

                // Kembalikan Stok
                foreach ($transaksi->detailTransaksiKeluar as $detail) {
                    Produk::where('id_produk', $detail->id_produk)->increment('stok', $detail->jumlah_barang);
                }

                $transaksi->delete();
            });

            return redirect()->back()->with('success', 'Transaksi berhasil dihapus & stok telah dikembalikan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    public function getDetail(string $id)
    {
        $transaksi = TransaksiKeluar::with(['customer', 'akun', 'detailTransaksiKeluar.produk'])->findOrFail($id);
        return response()->json($transaksi);
    }
}