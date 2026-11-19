<?php
namespace App\Http\Controllers\superadmin;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\Retur;
use App\Services\AuditLogger;
use App\Models\DetailRetur;
use App\Models\TransaksiMasuk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReturController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi masuk untuk dropdown
        $transaksiMasuk = TransaksiMasuk::with('supplier')->orderBy('id_transaksi_masuk', 'desc')->get();

        // Ambil history retur
        $retur = Retur::with(['akun', 'detailRetur.produk', 'detailRetur.transaksiMasuk.supplier'])->orderBy('id_retur', 'asc')->get();

        $view = auth()->user()->role === 'admin'
            ? 'dashboard.admin.retur'
            : 'dashboard.superadmin.retur';

        return view($view, compact('transaksiMasuk', 'retur'));
    }

    // Fungsi AJAX untuk ambil detail barang dari transaksi masuk yang dipilih
    public function getTransaksiDetail($id)
    {
        $transaksi = TransaksiMasuk::with(['supplier', 'akun', 'detailTransaksiMasuk.produk'])
            ->findOrFail($id);

        return response()->json($transaksi);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_transaksi_masuk' => 'required|exists:transaksi_masuk,id_transaksi_masuk',
            'alasan' => 'required|string|max:255',
            'dokumentasi' => 'nullable|image|max:2048',
            'id_produk' => 'required|array|min:1',
            'id_produk.*' => 'required|exists:produk,id_produk',
            'jumlah_retur' => 'required|array|min:1',
            'jumlah_retur.*' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request, $validated) {
                // 1. Upload Gambar
                $path = null;
                if ($request->hasFile('dokumentasi')) {
                    $path = $request->file('dokumentasi')->store('retur', 'public');
                }

                // 2. Simpan Header
                $idRetur = IdGenerator::buat('retur', 'id_retur', 'RTR');
                Retur::create([
                    'id_retur' => $idRetur,
                    'tanggal' => now(),
                    'alasan' => $validated['alasan'],
                    'dokumentasi_path' => $path,
                    'status_retur' => 'pending',
                    'id_akun' => auth()->user()->id_akun,
                ]);

                // 3. Simpan Detail
                foreach ($validated['id_produk'] as $index => $idProduk) {
                    $qtyRetur = (int) $validated['jumlah_retur'][$index];

                    if ($qtyRetur > 0) {
                        DetailRetur::create([
                            'id_detail_retur' => IdGenerator::buat('detail_retur', 'id_detail_retur', 'DTR'),
                            'id_retur' => $idRetur,
                            'id_produk' => $idProduk,
                            'id_transaksi_masuk' => $validated['id_transaksi_masuk'],
                            'jumlah_retur' => $qtyRetur,
                        ]);

                        Produk::where('id_produk', $idProduk)->decrement('stok', $qtyRetur);
                    }
                }
            });

            return redirect()->back()->with('success', 'Retur berhasil diajukan & stok telah dikoreksi');

        } catch (\Exception $e) {
            // INI PENTING: Biar lo tau error aslinya apa
            return redirect()->back()->with('error', 'Gagal memproses retur: ' . $e->getMessage())->withInput();
        }
    }

    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $retur = Retur::with('detailRetur')->lockForUpdate()->findOrFail($id);

                if ($retur->status_retur !== 'pending') {
                    throw new \Exception('Retur ini sudah diproses sebelumnya.');
                }

                // Kalau ditolak, kembalikan stok yang tadi sudah dikurangi saat pengajuan
                if ($request->status === 'rejected') {
                    foreach ($retur->detailRetur as $detail) {
                        Produk::where('id_produk', $detail->id_produk)
                            ->increment('stok', $detail->jumlah_retur);
                    }
                }

                $retur->update(['status_retur' => $request->status]);

                // TODO: catat ke AuditLog (status lama -> baru), sesuai komentar di migration
            });

            return redirect()->back()->with(
                'success',
                $request->status === 'approved' ? 'Retur disetujui.' : 'Retur ditolak & stok dikembalikan.'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'id_transaksi_masuk' => 'required|exists:transaksi_masuk,id_transaksi_masuk',
    //         'alasan'             => 'required|string|max:255',
    //         'dokumentasi'        => 'nullable|image|max:2048',
    //         'id_produk'          => 'required|array|min:1',
    //         'id_produk.*'        => 'required|exists:produk,id_produk',
    //         'jumlah_retur'       => 'required|array|min:1',
    //         'jumlah_retur.*'     => 'required|integer|min:1',
    //     ]);

    //     try {
    //         DB::transaction(function () use ($request, $validated) {
    //             // Upload Dokumentasi
    //             $path = $request->hasFile('dokumentasi')
    //                 ? $request->file('dokumentasi')->store('retur', 'public')
    //                 : null;

    //             // 1. Simpan Header Retur
    //             $idRetur = IdGenerator::buat('retur', 'id_retur', 'RTR');
    //             Retur::create([
    //                 'id_retur'         => $idRetur,
    //                 'tanggal'          => now(),
    //                 'alasan'           => $validated['alasan'],
    //                 'dokumentasi_path' => $path,
    //                 'status_retur'     => 'pending', // default
    //                 'id_akun'          => auth()->user()->id_akun,
    //             ]);

    //             // 2. Simpan Detail Retur & Kurangi Stok
    //             foreach ($validated['id_produk'] as $index => $idProduk) {
    //                 $qtyRetur = $validated['jumlah_retur'][$index];

    //                 if ($qtyRetur > 0) {
    //                     DetailRetur::create([
    //                         'id_detail_retur'    => IdGenerator::buat('detail_retur', 'id_detail_retur', 'DTR'),
    //                         'id_retur'           => $idRetur,
    //                         'id_produk'          => $idProduk,
    //                         'id_transaksi_masuk' => $validated['id_transaksi_masuk'],
    //                         'jumlah_retur'       => $qtyRetur,
    //                     ]);

    //                     // KURANGI STOK (Karena barang keluar dari gudang kita)
    //                     Produk::where('id_produk', $idProduk)->decrement('stok', $qtyRetur);
    //                 }
    //             }
    //         });

    //         return redirect()->back()->with('success', 'Retur berhasil diajukan & stok telah dikoreksi');

    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Gagal memproses retur: ' . $e->getMessage())->withInput();
    //     }
    // }
}