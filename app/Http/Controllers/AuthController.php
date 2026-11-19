<?php

namespace App\Http\Controllers;

use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $akun = Auth::user();

            if (in_array($akun->role, ['superadmin', 'admin'], true)) {
                AuditLogger::catat(
                    'login',
                    'akun',
                    $akun->id_akun,
                    $akun->nama,
                    "{$akun->nama} login sebagai {$akun->role}"
                );

                return redirect()->route(
                    $akun->role === 'superadmin' ? 'superadmin.dashboard' : 'admin.dashboard'
                );
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
        $akun = Auth::user();

        if ($akun) {
            AuditLogger::catat(
                'logout',
                'akun',
                $akun->id_akun,
                $akun->nama,
                "{$akun->nama} logout"
            );
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}