<?php

namespace App\Http\Controllers\Superadmin;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = TransaksiMasuk::with(['supplier', 'akun'])
            ->orderBy('id_transaksi_masuk', 'desc')
            ->get();

        $supplier = Supplier::orderBy('nama_supplier')->get();

        $view = auth()->user()->role === 'admin'
            ? 'dashboard.admin.barang_masuk'
            : 'dashboard.superadmin.barang_masuk';

        return view($view, compact('barangMasuk', 'supplier'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_supplier' => 'required|exists:supplier,id_supplier',
            'no_invoice' => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($validated) {
            TransaksiMasuk::create([
                'id_transaksi_masuk' => IdGenerator::buat('transaksi_masuk', 'id_transaksi_masuk', 'BM'),
                'tanggal' => now(),
                'no_invoice' => $validated['no_invoice'] ?? null,
                'id_supplier' => $validated['id_supplier'],
                'id_akun' => auth()->user()->id_akun,
            ]);
        });

        return redirect()->back()->with('success', 'Nota barang masuk berhasil dibuat');
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
}