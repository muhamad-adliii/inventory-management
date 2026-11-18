<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Helpers\IdGenerator;
use App\Services\AuditLogger; // <-- Import AuditLogger
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('produk')->orderBy('id_kategori', 'asc')->get();
        return view('dashboard.superadmin.kategori', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
        ]);

        DB::transaction(function () use ($validated) {
            $kategori = Kategori::create([
                'id_kategori' => IdGenerator::buat('kategori', 'id_kategori', 'KAT'),
                ...$validated,
            ]);

            // TAMBAHKAN AUDIT LOGGER
            AuditLogger::catat(
                'tambah_kategori',
                'kategori',
                $kategori->id_kategori,
                $kategori->nama_kategori,
                "Menambah kategori {$kategori->nama_kategori}"
            );
        });

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $kategori->id_kategori . ',id_kategori',
        ]);

        DB::transaction(function () use ($kategori, $validated) {
            $namaLama = $kategori->nama_kategori;
            $kategori->update($validated);

            // TAMBAHKAN AUDIT LOGGER
            AuditLogger::catat(
                'ubah_kategori',
                'kategori',
                $kategori->id_kategori,
                $kategori->nama_kategori,
                "Mengubah kategori dari '{$namaLama}' menjadi '{$kategori->nama_kategori}'"
            );
        });

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->produk()->exists()) {
            return redirect()->back()->with('error', 'Kategori masih digunakan oleh produk');
        }

        $idKategori = $kategori->id_kategori;
        $nama = $kategori->nama_kategori;

        try {
            DB::transaction(function () use ($kategori, $idKategori, $nama) {
                $kategori->delete();

                // TAMBAHKAN AUDIT LOGGER
                AuditLogger::catat(
                    'hapus_kategori',
                    'kategori',
                    $idKategori,
                    $nama,
                    "Menghapus kategori {$nama}"
                );
            });
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Kategori gagal dihapus karena terikat dengan data lain');
        }

        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}