<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Helpers\IdGenerator;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('produk')
            ->orderBy('id_kategori', 'asc')
            ->get();

        return view('dashboard.superadmin.kategori', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
        ]);

        DB::transaction(function () use ($validated) {
            Kategori::create([
                'id_kategori' => IdGenerator::buat('kategori', 'id_kategori', 'KAT'),
                ...$validated,
            ]);
        });

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $kategori->id_kategori . ',id_kategori',
        ]);
        $kategori->update($validated);
        return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        if ($kategori->produk()->exists()) {
            return redirect()->back()->with('error', 'Kategori masih digunakan oleh produk');
        }
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}