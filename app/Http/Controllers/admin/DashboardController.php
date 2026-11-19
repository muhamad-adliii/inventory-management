<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;
use App\Models\Retur;

class DashboardController extends Controller
{
    public function index()
    {
        $idAkun = auth()->user()->id_akun;

        return view('dashboard.admin.dashboard', [
            'totalMasuk' => TransaksiMasuk::where('id_akun', $idAkun)->count(),
            'totalKeluar' => TransaksiKeluar::where('id_akun', $idAkun)->count(),
            'totalRetur' => Retur::where('id_akun', $idAkun)->count(),
        ]);
    }
}