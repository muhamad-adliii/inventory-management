<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\TransaksiKeluar;
use App\Models\DetailTransaksiKeluar;
use App\Models\Customer;
use App\Models\Produk;
use App\Services\AuditLogger; // <-- Tambahan Import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiKeluarController extends Controller
{
    public function index()
    {
        $transaksiKeluar = TransaksiKeluar::with(['customer', 'akun', 'detailTransaksiKeluar.produk'])
            ->orderBy('id_transaksi_keluar', 'asc')
            ->get();

        $customer = Customer::orderBy('nama_customer')->get();
        $produk = Produk::orderBy('nama_produk')->get();

        $view = auth()->user()->role === 'admin'
            ? 'dashboard.admin.transaksi_keluar'
            : 'dashboard.superadmin.transaksi_keluar';

        return view($view, compact('transaksiKeluar', 'customer', 'produk'));
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'id_customer' => 'required|exists:customer,id_customer',
    //         'items' => 'required|array|min:1',
    //         'items.*.id_produk' => 'required|exists:produk,id_produk',
    //         'items.*.qty' => 'required|integer|min:1',
    //         'items.*.harga' => 'required|numeric|min:0',
    //     ]);

    //     try {
    //         DB::transaction(function () use ($validated) {
    //             // 1. Cek Stok
    //             foreach ($validated['items'] as $item) {
    //                 $produk = Produk::where('id_produk', $item['id_produk'])->lockForUpdate()->first();
    //                 if ($produk->stok < $item['qty']) {
    //                     throw new \Exception("Stok produk {$produk->nama_produk} tidak mencukupi. Sisa: {$produk->stok}");
    //                 }
    //             }

    //             // 2. Simpan Header
    //             $idTransaksi = IdGenerator::buat('transaksi_keluar', 'id_transaksi_keluar', 'BK');
    //             TransaksiKeluar::create([
    //                 'id_transaksi_keluar' => $idTransaksi,
    //                 'tanggal' => now(),
    //                 'id_customer' => $validated['id_customer'],
    //                 'id_akun' => auth()->user()->id_akun,
    //             ]);

    //             $ringkasanBarang = []; // Array untuk nyatet nama barang di log

    //             // 3. Simpan Detail & Kurangi Stok
    //             foreach ($validated['items'] as $item) {
    //                 DetailTransaksiKeluar::create([
    //                     'id_detail_keluar' => IdGenerator::buat('detail_transaksi_keluar', 'id_detail_keluar', 'DTK'),
    //                     'id_transaksi_keluar' => $idTransaksi,
    //                     'id_produk' => $item['id_produk'],
    //                     'jumlah_barang' => $item['qty'],
    //                     'harga_satuan' => $item['harga'],
    //                     'total_harga' => $item['qty'] * $item['harga'],
    //                 ]);

    //                 Produk::where('id_produk', $item['id_produk'])->decrement('stok', $item['qty']);

    //                 // Ambil nama produk buat log
    //                 $namaProduk = Produk::where('id_produk', $item['id_produk'])->value('nama_produk');
    //                 $ringkasanBarang[] = "{$namaProduk} ({$item['qty']})";
    //             }

    //             // TAMBAHKAN AUDIT LOGGER
    //             $detailLog = implode(', ', $ringkasanBarang);
    //             AuditLogger::catat(
    //                 'transaksi_keluar',
    //                 'transaksi_keluar',
    //                 $idTransaksi,
    //                 $idTransaksi,
    //                 "Input transaksi keluar {$namaProduk}"
    //             );
    //         });

    //         return redirect()->back()->with('success', 'Transaksi keluar berhasil disimpan & stok diperbarui');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', $e->getMessage())->withInput();
    //     }
    // }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_customer' => 'required|exists:customer,id_customer',
            'items' => 'required|array|min:1',
            'items.*.id_produk' => 'required|exists:produk,id_produk',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // 1. Cek Stok
                foreach ($validated['items'] as $item) {
                    $produk = Produk::where('id_produk', $item['id_produk'])->lockForUpdate()->first();
                    if ($produk->stok < $item['qty']) {
                        throw new \Exception("Stok produk {$produk->nama_produk} tidak mencukupi. Sisa: {$produk->stok}");
                    }
                }

                // 2. Hitung Total Keseluruhan
                $totalKeseluruhan = 0;
                foreach ($validated['items'] as $item) {
                    $totalKeseluruhan += $item['qty'] * $item['harga'];
                }

                // 3. Simpan Header
                $idTransaksi = IdGenerator::buat('transaksi_keluar', 'id_transaksi_keluar', 'BK');
                TransaksiKeluar::create([
                    'id_transaksi_keluar' => $idTransaksi,
                    'tanggal' => now(),
                    'total_harga' => $totalKeseluruhan, // <-- SIMPAN TOTALNYA
                    'id_customer' => $validated['id_customer'],
                    'id_akun' => auth()->user()->id_akun,
                ]);

                $ringkasanBarang = [];

                // 4. Simpan Detail & Kurangi Stok
                foreach ($validated['items'] as $item) {
                    DetailTransaksiKeluar::create([
                        'id_detail_keluar' => IdGenerator::buat('detail_transaksi_keluar', 'id_detail_keluar', 'DTK'),
                        'id_transaksi_keluar' => $idTransaksi,
                        'id_produk' => $item['id_produk'],
                        'jumlah_barang' => $item['qty'],
                        'harga_satuan' => $item['harga'],
                        'sub_total' => $item['qty'] * $item['harga'],
                    ]);

                    Produk::where('id_produk', $item['id_produk'])->decrement('stok', $item['qty']);
                    
                    $namaProduk = Produk::where('id_produk', $item['id_produk'])->value('nama_produk');
                    $ringkasanBarang[] = "{$namaProduk} ({$item['qty']})";
                }

                // 5. Audit Log
                $detailLog = implode(', ', $ringkasanBarang);
                AuditLogger::catat(
                    'transaksi_keluar',
                    'transaksi_keluar',
                    $idTransaksi,
                    $idTransaksi,
                    "Input transaksi keluar. Barang: {$detailLog}"
                );
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
                
                $ringkasanBarang = [];

                foreach ($transaksi->detailTransaksiKeluar as $detail) {
                    Produk::where('id_produk', $detail->id_produk)->increment('stok', $detail->jumlah_barang);

                    // Ambil nama produk buat log
                    $namaProduk = Produk::where('id_produk', $detail->id_produk)->value('nama_produk');
                    $ringkasanBarang[] = "{$namaProduk} ({$detail->jumlah_barang})";
                }

                $transaksi->delete();

                // TAMBAHKAN AUDIT LOGGER UNTUK HAPUS
                $detailLog = implode(', ', $ringkasanBarang);
                AuditLogger::catat(
                    'hapus_transaksi_keluar',
                    'transaksi_keluar',
                    $id,
                    $id,
                    "Menghapus transaksi keluar (Stok dikembalikan). Barang: {$detailLog}"
                );
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