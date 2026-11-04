<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('kategori')->latest()->get();
        $kategori = Kategori::all();

        return view(
            'dashboard.superadmin.barang',
            compact('barang', 'kategori')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategori,id',
            'kode_barang' => 'required|string|max:50|unique:barang,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
        ]);

        Barang::create($validated);

        return redirect()->back()
            ->with('success', 'Barang berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategori,id',
            'kode_barang' => [
                'required',
                'string',
                'max:50',
                Rule::unique('barang', 'kode_barang')->ignore($barang->id),
            ],
            'nama_barang' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
        ]);

        $barang->update($validated);

        return redirect()->back()
            ->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->stock > 0) {
            return redirect()->back()
                ->with('error', 'Barang dengan stok tersedia tidak dapat dihapus');
        }

        $barang->delete();

        return redirect()->back()
            ->with('success', 'Barang berhasil dihapus');
    }
}