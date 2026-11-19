<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('dashboard.pengaturan', [
            'akun' => auth()->user(),
        ]);
    }

    public function updateProfil(Request $request)
    {
        $akun = auth()->user();

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('akun', 'username')->ignore($akun->id_akun, 'id_akun'),
            ],
        ]);

        $akun->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'password_lama' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $akun = auth()->user();

        if (!Hash::check($validated['password_lama'], $akun->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        $akun->update(['password' => Hash::make($validated['password'])]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}