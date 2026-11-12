<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Supplier;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with(['kategori', 'supplier'])->orderBy('id_produk', 'asc')->get();
        $kategori = Kategori::all();
        $supplier = Supplier::all();

        $view = auth()->user()->role === 'admin'
            ? 'dashboard.admin.barang'
            : 'dashboard.superadmin.produk';

        return view($view, compact('produk', 'kategori', 'supplier'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|in:pcs,unit,karton',
            'deskripsi' => 'nullable|string',
            'lokasi_rak' => 'nullable|string|max:50',
            'gambar' => 'nullable|image|max:2048',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_supplier' => 'required|exists:supplier,id_supplier',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $path = $request->hasFile('gambar')
                ? $request->file('gambar')->store('produk', 'public')
                : null;

            $produk = Produk::create([
                'id_produk' => IdGenerator::buat('produk', 'id_produk', 'PRD'),
                'nama_produk' => $validated['nama_produk'],
                'harga' => $validated['harga'],
                'stok' => $validated['stok'],
                'satuan' => $validated['satuan'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'lokasi_rak' => $validated['lokasi_rak'] ?? null,
                'path_gambar' => $path,
                'id_kategori' => $validated['id_kategori'],
                'id_supplier' => $validated['id_supplier'],
            ]);

            AuditLogger::catat(
                'tambah_produk',
                'produk',
                $produk->id_produk,
                $produk->nama_produk,
                "Menambah produk {$produk->nama_produk}"
            );
        });

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|in:pcs,unit,karton',
            'deskripsi' => 'nullable|string',
            'lokasi_rak' => 'nullable|string|max:50',
            'gambar' => 'nullable|image|max:2048',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'id_supplier' => 'required|exists:supplier,id_supplier',
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->path_gambar) {
                Storage::disk('public')->delete($produk->path_gambar);
            }
            $validated['path_gambar'] = $request->file('gambar')->store('produk', 'public');
        }
        unset($validated['gambar']);

        $produk->update($validated);

        return redirect()->back()->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->stok > 0) {
            return redirect()->back()->with('error', 'Produk dengan stok tersedia tidak dapat dihapus');
        }

        $idProduk = $produk->id_produk;
        $nama = $produk->nama_produk;

        try {
            DB::transaction(function () use ($produk, $idProduk, $nama) {
                $produk->delete();
                AuditLogger::catat('hapus_produk', 'produk', $idProduk, $nama, "Menghapus produk {$nama}");
            });
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Produk sudah dipakai di transaksi, tidak dapat dihapus');
        }

        return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }
}