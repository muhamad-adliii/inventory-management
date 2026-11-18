<?php

namespace App\Http\Controllers\superadmin;

use App\Helpers\IdGenerator;
use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $users = Akun::query()
            ->when($request->filled('name'), fn($q) => $q->where('nama', 'like', '%' . $request->name . '%'))
            ->when($request->filled('username'), fn($q) => $q->where('username', 'like', '%' . $request->username . '%'))
            ->when($request->filled('role'), fn($q) => $q->where('role', $request->role))
            ->orderBy('created_at', $request->sort === 'terlama' ? 'asc' : 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.superadmin.akun', [
            'users' => $users,
            'totalUsers' => Akun::count(),
            'totalSuperadmin' => Akun::where('role', 'superadmin')->count(),
            'totalAdmin' => Akun::where('role', 'admin')->count(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:akun,username',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['admin', 'superadmin'])],
        ]);

        // superadmin => SADM001, admin => ADM001
        $prefix = $validated['role'] === 'superadmin' ? 'SADM' : 'ADM';

        DB::transaction(function () use ($validated, $prefix) {
            Akun::create([
                'id_akun' => IdGenerator::buat('akun', 'id_akun', $prefix),
                'nama' => $validated['nama'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);
        });

        return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $akun = Akun::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'username' => ['required', 'string', 'max:50', Rule::unique('akun', 'username')->ignore($akun->id_akun, 'id_akun')],
            'password' => 'nullable|string|min:8',
        ]);

        $akun->nama = $validated['nama'];
        $akun->username = $validated['username'];

        // Password hanya diganti kalau diisi. Role tidak bisa diubah karena ID (ADM/SADM) bergantung padanya.
        if (!empty($validated['password'])) {
            $akun->password = Hash::make($validated['password']);
        }

        $akun->save();

        return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $akun = Akun::findOrFail($id);

        if ($akun->id_akun === auth()->id()) {
            return back()->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        $akun->delete();

        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus.');
    }
}