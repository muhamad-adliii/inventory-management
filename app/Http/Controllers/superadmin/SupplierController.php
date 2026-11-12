<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::withCount('produk')
            ->orderBy('id_supplier', 'asc')
            ->get();

        return view('dashboard.superadmin.supplier', compact('supplier'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        DB::transaction(function () use ($validated) {
            Supplier::create([
                'id_supplier' => IdGenerator::buat('supplier', 'id_supplier', 'SUP'),
                ...$validated,
            ]);
        });

        return redirect()->back()->with('success', 'Supplier berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        $supplier->update($validated);

        return redirect()->back()->with('success', 'Supplier berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);

        if ($supplier->produk()->exists()) {
            return redirect()->back()->with('error', 'Supplier masih digunakan oleh produk');
        }

        $supplier->delete();

        return redirect()->back()->with('success', 'Supplier berhasil dihapus');
    }
}