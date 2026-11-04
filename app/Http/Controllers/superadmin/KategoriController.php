<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->get();

        return view(
            'dashboard.superadmin.kategori',
            compact('kategori')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
        ]);

        Kategori::create($validated);

        return redirect()->back()
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                'unique:kategori,nama_kategori,' . $kategori->id,
            ],
        ]);

        $kategori->update($validated);

        return redirect()->back()
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->barang()->exists()) {
            return redirect()->back()
                ->with('error', 'Kategori masih digunakan oleh barang');
        }

        $kategori->delete();

        return redirect()->back()
            ->with('success', 'Kategori berhasil dihapus');
    }
}