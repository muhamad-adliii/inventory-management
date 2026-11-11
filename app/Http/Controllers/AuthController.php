<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    // Proses autentikasi
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (
            Auth::attempt(
                $credentials,
                $request->boolean('remember')
            )
        ) {

            $request->session()->regenerate();
            $akun = Auth::user();
            if ($akun->role === 'superadmin') {
                return redirect()->intended(route('superadmin.dashboard'));
            }

            if ($akun->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            Auth::logout();

            return back()->withErrors([
                'username' => 'Role akun tidak dikenali.',
            ]);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
