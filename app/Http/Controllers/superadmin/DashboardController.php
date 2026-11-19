<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar; // <-- Tambahkan ini
use App\Models\Produk;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStok = Produk::sum('stok'); 
        
        // --- DATA TRANSAKSI MASUK ---
        $dataMasuk = TransaksiMasuk::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan')->toArray();

        // --- DATA TRANSAKSI KELUAR ---
        $dataKeluar = TransaksiKeluar::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan')->toArray();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartDataMasuk = [];
        $chartDataKeluar = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $chartDataMasuk[] = $dataMasuk[$i] ?? 0;
            $chartDataKeluar[] = $dataKeluar[$i] ?? 0;
        }

        return view('dashboard.superadmin.dashboard', compact(
            'totalStok', 
            'labels', 
            'chartDataMasuk', 
            'chartDataKeluar' // <-- Kirim data keluar
        ));
    }
}