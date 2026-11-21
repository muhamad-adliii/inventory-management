<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Label tiap jenis laporan (dipakai di kartu & tabel).
     */
    private const JENIS = [
        'penjualan' => [
            'nama' => 'Penjualan',
            'pihak' => 'Customer',
            'total' => 'Total Penjualan',
            'trx' => 'Total Transaksi',
            'qty' => 'Barang Terjual',
            'hari' => 'Pendapatan Hari Ini',
        ],
        'masuk' => [
            'nama' => 'Barang Masuk',
            'pihak' => 'Supplier',
            'total' => 'Total Pembelian',
            'trx' => 'Total Transaksi',
            'qty' => 'Barang Masuk',
            'hari' => 'Pembelian Hari Ini',
        ],
        'retur' => [
            'nama' => 'Retur',
            'pihak' => 'Supplier',
            'total' => 'Total Nilai Retur',
            'trx' => 'Total Retur',
            'qty' => 'Barang Diretur',
            'hari' => 'Nilai Retur Hari Ini',
        ],
    ];

    public function index(Request $request)
    {
        $data = $request->validate([
            'jenis' => 'nullable|in:penjualan,masuk,retur',
            'mulai' => 'nullable|date',
            'selesai' => 'nullable|date|after_or_equal:mulai',
            'q' => 'nullable|string|max:100',
        ]);

        $jenis = $data['jenis'] ?? 'penjualan';
        $mulai = $data['mulai'] ?? now()->startOfMonth()->toDateString();
        $selesai = $data['selesai'] ?? now()->toDateString();
        $q = trim($data['q'] ?? '');
        $meta = self::JENIS[$jenis];

        $base = fn() => DB::query()
            ->fromSub($this->sumber($jenis), 't')
            ->whereBetween('tanggal', ["$mulai 00:00:00", "$selesai 23:59:59"]);

        $filtered = fn() => $base()->when($q !== '', function ($query) use ($q) {
            $query->where(function ($w) use ($q) {
                $like = "%{$q}%";
                $w->where('kode', 'like', $like)
                    ->orWhere('produk', 'like', $like)
                    ->orWhere('pihak', 'like', $like)
                    ->orWhere('admin', 'like', $like);
            });
        });

        if ($request->boolean('export')) {
            return $this->exportCsv($filtered(), $jenis, $meta, $mulai, $selesai);
        }

        $ringkas = $base()->selectRaw(
            'COUNT(DISTINCT kode) AS transaksi, COALESCE(SUM(qty), 0) AS qty, COALESCE(SUM(total), 0) AS total'
        )->first();

        $hariIni = DB::query()
            ->fromSub($this->sumber($jenis), 't')
            ->whereDate('tanggal', today())
            ->sum('total');

        $detail = $filtered()->selectRaw(
            'COUNT(DISTINCT id_produk) AS item, COALESCE(SUM(qty), 0) AS qty, COALESCE(SUM(total), 0) AS total'
        )->first();

        $rows = $filtered()
            ->orderByDesc('tanggal')
            ->orderByDesc('kode')
            ->orderBy('produk')
            ->paginate(10)
            ->withQueryString();

        $view = auth()->user()->role === 'admin'
            ? 'dashboard.admin.laporan'
            : 'dashboard.superadmin.laporan';
        return view($view, compact(
            'rows',
            'ringkas',
            'detail',
            'hariIni',
            'meta',
            'jenis',
            'mulai',
            'selesai',
            'q'
        ));
    }

    private function sumber(string $jenis)
    {
        return match ($jenis) {
            'masuk' => DB::table('detail_transaksi_masuk as d')
                ->join('transaksi_masuk as tm', 'tm.id_transaksi_masuk', '=', 'd.id_transaksi_masuk')
                ->join('produk as p', 'p.id_produk', '=', 'd.id_produk')
                ->join('supplier as s', 's.id_supplier', '=', 'tm.id_supplier')
                ->join('akun as a', 'a.id_akun', '=', 'tm.id_akun')
                ->selectRaw('tm.id_transaksi_masuk AS kode, tm.tanggal, d.id_produk,
                    p.nama_produk AS produk, d.jumlah_barang AS qty, d.sub_total AS total,
                    s.nama_supplier AS pihak, a.nama AS admin, NULL AS keterangan'),

            'retur' => DB::table('detail_retur as dr')
                ->join('retur as r', 'r.id_retur', '=', 'dr.id_retur')
                ->join('produk as p', 'p.id_produk', '=', 'dr.id_produk')
                ->join('transaksi_masuk as tm', 'tm.id_transaksi_masuk', '=', 'dr.id_transaksi_masuk')
                ->join('supplier as s', 's.id_supplier', '=', 'tm.id_supplier')
                ->join('akun as a', 'a.id_akun', '=', 'r.id_akun')
                ->where('r.status_retur', 'approved')
                ->selectRaw('r.id_retur AS kode, r.tanggal, dr.id_produk,
                    p.nama_produk AS produk, dr.jumlah_retur AS qty,
                    dr.jumlah_retur * (
                        SELECT dm.harga_satuan FROM detail_transaksi_masuk dm
                        WHERE dm.id_transaksi_masuk = dr.id_transaksi_masuk
                          AND dm.id_produk = dr.id_produk
                        LIMIT 1
                    ) AS total,
                    s.nama_supplier AS pihak, a.nama AS admin, r.alasan AS keterangan'),

            default => DB::table('detail_transaksi_keluar as d')
                ->join('transaksi_keluar as tk', 'tk.id_transaksi_keluar', '=', 'd.id_transaksi_keluar')
                ->join('produk as p', 'p.id_produk', '=', 'd.id_produk')
                ->join('customer as c', 'c.id_customer', '=', 'tk.id_customer')
                ->join('akun as a', 'a.id_akun', '=', 'tk.id_akun')
                ->selectRaw('tk.id_transaksi_keluar AS kode, tk.tanggal, d.id_produk,
                    p.nama_produk AS produk, d.jumlah_barang AS qty, d.sub_total AS total,
                    c.nama_customer AS pihak, a.nama AS admin, NULL AS keterangan'),
        };
    }
    private function exportCsv($query, string $jenis, array $meta, string $mulai, string $selesai)
    {
        $namaFile = "laporan-{$jenis}-{$mulai}-sd-{$selesai}.csv";

        return response()->streamDownload(function () use ($query, $jenis, $meta) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM supaya Excel membaca UTF-8

            $header = ['No', 'Kode', 'Tanggal', 'Produk', 'Qty', 'Total', $meta['pihak'], 'Admin'];
            if ($jenis === 'retur') {
                $header[] = 'Alasan';
            }
            fputcsv($out, $header, ';');

            $no = 0;
            foreach ($query->orderByDesc('tanggal')->orderByDesc('kode')->cursor() as $row) {
                $line = [++$no, $row->kode, $row->tanggal, $row->produk, $row->qty, $row->total, $row->pihak, $row->admin];
                if ($jenis === 'retur') {
                    $line[] = $row->keterangan;
                }
                fputcsv($out, $line, ';');
            }

            fclose($out);
        }, $namaFile, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}