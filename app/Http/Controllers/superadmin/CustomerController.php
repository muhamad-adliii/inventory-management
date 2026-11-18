<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Helpers\IdGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::orderBy('id_customer', 'asc')->get();

        return view('dashboard.superadmin.customer', compact('customer'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_customer' => 'required|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($validated) {
            Customer::create([
                'id_customer' => IdGenerator::buat('customer', 'id_customer', 'CUS'),
                ...$validated,
            ]);
        });

        return redirect()->back()->with('success', 'Customer berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'nama_customer' => 'required|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
        ]);

        $customer->update($validated);

        return redirect()->back()->with('success', 'Customer berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->back()->with('success', 'Customer berhasil dihapus');
    }
}
