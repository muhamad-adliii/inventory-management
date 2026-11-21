@extends('layouts.app-superadmin')

@section('content')
<div class="p-4 md:p-6 bg-[#ffffff] rounded-xl">
    <div class="text-header text-xl md:text-2xl uppercase font-medium">
        <h3>Super Admin dashboard</h3>
    </div>
    
    <div class="card-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mt-5">
        <!-- Card Total Barang (Dinamis dari DB) -->
        <div class="card flex items-center p-4 md:p-5 bg-[#e4f5ff] justify-between rounded-lg">
            <div class="capitalize space-y-2 md:space-y-4">
                <h3 class="text-gray-600 font-medium text-sm md:text-base">total stok barang</h3>
                <p class="font-bold text-2xl md:text-3xl">{{ number_format($totalStok, 0, ',', '.') }}</p>
            </div>
            <div>
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 md:size-10 text-[#64ccff]"><path stroke-linecap="round" stroke-linejoin="round" d="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 0 1 1.872 1.002l.164.246a2.25 2.25 0 0 0 1.872 1.002h2.092a2.25 2.25 0 0 0 1.872-1.002l.164-.246A2.25 2.25 0 0 1 16.954 9h4.636M2.41 9a2.25 2.25 0 0 0-.16.832V12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 0 1 .382-.632l3.285-3.832a2.25 2.25 0 0 1 1.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
            </div>
        </div>
        
        <!-- Card Stok (Bisa lo isi query lain nanti) -->
        <div class="card flex items-center p-4 md:p-5 bg-[#f1e7ff] justify-between rounded-lg">
            <div class="capitalize space-y-2 md:space-y-4">
                <h3 class="text-gray-600 font-medium text-sm md:text-base">stok</h3>
                <p class="font-bold text-2xl md:text-3xl">400</p>
            </div>
            <div>
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 md:size-10 text-[#af7bf4]"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125"/></svg>
            </div>
        </div>

        <!-- Card Penjualan Hari Ini -->
        <div class="card flex items-center p-4 md:p-5 bg-[#ffefe7] justify-between rounded-lg">
            <div class="capitalize space-y-2 md:space-y-4">
                <h3 class="text-gray-600 font-medium text-sm md:text-base">penjualan hari ini</h3>
                <p class="font-bold text-2xl md:text-3xl">500</p>
            </div>
            <div>
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 md:size-10 text-[#ff9866]"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/></svg>
            </div>
        </div>

        <!-- Card Pendapatan -->
        <div class="card flex items-center p-4 md:p-5 bg-[#ebfdef] justify-between rounded-lg">
            <div class="capitalize space-y-2 md:space-y-4">
                <h3 class="text-gray-600 font-medium text-sm md:text-base">pendapatan</h3>
                <p class="font-bold text-2xl md:text-3xl">2.000.000</p>
            </div>
            <div>
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 md:size-10 text-[#5cca76]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 mb-16">
    <div class="bg-white rounded-xl shadow p-4 md:p-6">
        <h2 class="font-medium mb-4 capitalize text-lg md:text-xl">Grafik Transaksi Masuk & Keluar (Tahun {{ date('Y') }})</h2>
        <div class="chart-container" style="height: 300px; width: 100%; position: relative;">
            <canvas id="myChart" style="width: 100%; height: 100%;"></canvas>
        </div>
    </div>
</div>
<!-- TABEL STOK MINIMUM -->
<div class="mt-6">
    <div class="bg-white rounded-xl shadow p-4 md:p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-medium capitalize text-lg md:text-xl text-gray-800">⚠️ Peringatan Stok Menipis</h2>
            <a href="{{ route('superadmin.produk') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua Produk</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-xs uppercase tracking-wider text-gray-700 border-b border-gray-200">
                        <th class="py-3 px-2 text-left">No</th>
                        <th class="py-3 px-2 text-left">Nama Produk</th>
                        <th class="py-3 px-2 text-left">Sisa Stok</th>
                        <th class="py-3 px-2 text-left">Batas Minimum</th>
                        <th class="py-3 px-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stokKritis as $item)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-2">{{ $loop->iteration }}</td>
                            <td class="py-3 px-2 font-medium text-gray-800">{{ $item->nama_produk }}</td>
                            <td class="py-3 px-2 font-bold text-red-600">{{ $item->stok }} {{ $item->satuan }}</td>
                            <td class="py-3 px-2 text-gray-500">{{ $item->stok_minimum }} {{ $item->satuan }}</td>
                            <td class="py-3 px-2">
                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">
                                    Segera Restock
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-green-600 font-medium">
                                ✅ Semua stok produk aman terkendali.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pastikan file JS lo di-include di sini -->
<!-- ... bagian HTML card dan canvas lo yang tadi ... -->

<script src="{{ asset('js/chart-lo.js') }}"></script> 

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Inisialisasi Chart
        initChart();

        // 2. Ambil data dari Controller
        const labels = {!! json_encode($labels) !!};
        const dataMasuk = {!! json_encode($chartDataMasuk) !!};
        const dataKeluar = {!! json_encode($chartDataKeluar) !!};

        // 3. Update Chart dengan 2 Dataset (Masuk & Keluar)
        setTimeout(() => {
            if (chartInstance) {
                // Suntikkan Labels
                chartInstance.data.labels = labels;

                // Dataset 1: Transaksi Masuk (Warna Hijau)
                chartInstance.data.datasets[0].label = 'Transaksi Masuk';
                chartInstance.data.datasets[0].data = dataMasuk;
                chartInstance.data.datasets[0].backgroundColor = 'rgba(75, 192, 192, 0.5)';
                chartInstance.data.datasets[0].borderColor = 'rgb(75, 192, 192)';

                // Dataset 2: Transaksi Keluar (Warna Merah/Orange)
                // Kita push dataset baru kalau belum ada
                if (chartInstance.data.datasets.length < 2) {
                    chartInstance.data.datasets.push({
                        label: 'Transaksi Keluar',
                        data: dataKeluar,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgb(255, 99, 132)',
                        borderWidth: 1,
                        borderRadius: 6,
                        barPercentage: .7,
                        categoryPercentage: .8
                    });
                } else {
                    // Kalau udah ada (misal habis refresh), tinggal update datanya
                    chartInstance.data.datasets[1].data = dataKeluar;
                }

                // Render ulang chart
                chartInstance.update();
            }
        }, 100);
    });
</script>
@endsection