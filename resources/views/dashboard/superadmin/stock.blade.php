@extends('layouts.app-superadmin')

@section('content')
    <div class="p-6">
        <div class="">
            <h3 class="text-2xl font-medium ">STOCK</h3>
        </div>

        <!-- ringkasan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 my-8">
            <!-- Total Barang Masuk -->
            <div class="bg-[#f1e7ff] rounded-2xl shadow-soft p-5 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Barang Masuk</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="totalTransaksiVal">120</p>
                    </div>
                    <i class="fas fa-receipt text-blue-400 text-3xl opacity-80"></i>
                </div>
            </div>
            <!-- Barang Terjual -->
            <div class="bg-[#ffefe7] rounded-2xl shadow-soft p-5 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Barang Keluar</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="totalQtyVal">80 Item</p>
                    </div>
                    <i class="fas fa-boxes text-amber-400 text-3xl opacity-80"></i>
                </div>
            </div>
            <!-- Pendapatan Hari Ini -->
            <div class="bg-[#ebfdef] rounded-2xl shadow-soft p-5 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Perubahan Stock</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="pendapatanHariIniVal">Rp 50</p>
                    </div>
                    <i class="fas fa-coins text-indigo-400 text-3xl opacity-80"></i>
                </div>
            </div>
        </div>

        <!--  Filter & Data Laporan  -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 md:p-6 mt-5">
            <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 gap-5">
                <!-- Search -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">
                        Cari Laporan
                    </label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" placeholder="Search..."
                            class="w-full h-11 pl-10 pr-4 border border-gray-200 rounded-xl
                                                                                                                    bg-gray-50 focus:bg-white
                                                                                                                    focus:outline-none focus:ring-2 focus:ring-indigo-200
                                                                                                                    focus:border-indigo-300 transition">
                    </div>
                </div>
                <!-- Filter Tanggal -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">
                        Filter Tanggal
                    </label>
                    <div class="flex flex-col xl:flex-row items-center gap-2">
                        <input type="date" class="w-full h-11 border border-gray-200 rounded-xl px-3
                                        bg-gray-50 focus:bg-white
                                        focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                        <span class="hidden xl:block text-gray-400">-</span>
                        <input type="date" class="w-full h-11 border border-gray-200 rounded-xl px-3
                                        bg-gray-50 focus:bg-white
                                        focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                    </div>
                </div>
                <!-- Jenis -->
                <div class="pl-0 2xl:pl-30 flex flex-col ">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">
                        Jenis
                    </label>
                    <select class="w-full h-11 border border-gray-200 rounded-xl px-2
                                                                        bg-gray-50 focus:bg-white
                                                                        focus:outline-none focus:ring-2 focus:ring-indigo-200
                                                                        cursor-pointer transition">
                        <option>Semua</option>
                        <option>Barang Masuk</option>
                        <option>Barang Keluar</option>
                        <option>Penyesuaian Stock</option>
                        <option>Retur</option>
                        <option>Penjualan</option>
                    </select>
                </div>
                <!-- Kategori -->
                <div class="">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">
                        Kategori
                    </label>
                    <select class="w-full h-11 border border-gray-200 rounded-xl px-4
                                                                        bg-gray-50 focus:bg-white
                                                                        focus:outline-none focus:ring-2 focus:ring-indigo-200
                                                                        cursor-pointer transition">
                        <option>Semua</option>
                        <option>Makanan</option>
                        <option>Minuman</option>
                        <option>Snack</option>
                        <option>Elektronik</option>
                        <option>Alat Tulis</option>
                        <option>Kesehatan</option>
                    </select>
                </div>
            </div>

            <!-- Data & Laporan -->
            <div class="bg-white rounded-2xl shadow-card overflow-hidden border border-gray-100 mt-6">
                <div class="px-6 py-4 border-b bg-gray-50/80 flex items-center gap-2">
                    <i class="fas fa-table-list text-indigo-500"></i>
                    <h2 class="font-semibold text-gray-700 text-lg">Data Laporan</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wider">
                            <tr>
                                <th class="px-5 py-4 text-left">No</th>
                                <th class="px-5 py-4 text-left">Tanggal</th>
                                <th class="px-5 py-4 text-left">Barang</th>
                                <th class="px-5 py-4 text-center">JENIS</th>
                                <th class="px-5 py-4 text-left">Qty</th>
                                <th class="px-5 py-4 text-left">Stock AWAL</th>
                                <th class="px-5 py-4 text-left">Stock AKHIR</th>
                                <th class="px-5 py-4 text-left">USER</th>
                                <th class="px-5 py-4 text-left">KETERANGAN</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-3 font-medium text-gray-700">1</td>
                                <td class="px-5 py-3 font-medium text-gray-700">2026-05-07</td>
                                <td class="px-5 py-3 font-medium text-gray-700">Indomie</td>
                                <td class="px-5 py-3 font-medium text-gray-700">Barang Masuk</td>
                                <td class="px-5 py-3 font-medium text-gray-700">20</td>
                                <td class="px-5 py-3 font-medium text-gray-700">50</td>
                                <td class="px-5 py-3 font-medium text-gray-700">70</td>
                                <td class="px-5 py-3 font-medium text-gray-700">Admin</td>
                                <td class="px-5 py-3 font-medium text-gray-700">Restock Gudang</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--  Detail Laporan  -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-8">
            <div
                class="bg-linear-to-br from-white to-gray-50 rounded-2xl shadow-soft p-5 flex items-center justify-between border border-gray-100 shadow-xl">
                <div>
                    <p class="text-gray-500 text-sm">Total Item</p>
                    <p class="text-3xl font-black text-gray-800" id="detailTotalItem">4</p>
                </div>
                <i class="fas fa-tags text-indigo-300 text-4xl"></i>
            </div>
            <div
                class="bg-linear-to-br from-white to-gray-50 rounded-2xl shadow-soft p-5 flex items-center justify-between border border-gray-100 shadow-xl">
                <div>
                    <p class="text-gray-500 text-sm">Total Qty</p>
                    <p class="text-3xl font-black text-gray-800" id="detailTotalQty">8</p>
                </div>
                <i class="fas fa-cubes text-emerald-300 text-4xl"></i>
            </div>
            <div
                class="bg-linear-to-br from-white to-gray-50 rounded-2xl shadow-soft p-5 flex items-center justify-between border border-gray-100 shadow-xl">
                <div>
                    <p class="text-gray-500 text-sm">Total Pendapatan</p>
                    <p class="text-3xl font-black text-gray-800" id="detailTotalPendapatan">Rp 41.000</p>
                </div>
                <i class="fas fa-money-bill-wave text-amber-400 text-4xl"></i>
            </div>
        </div>
        <!-- PAGINATION & EXPORT  -->
        <div
            class="flex flex-col md:flex-row justify-between items-center gap-5 bg-white rounded-2xl shadow-soft p-4 border border-gray-100 shadow-xl mt-8">
            <!-- Pagination -->
            <div class="flex flex-wrap items-center gap-2">
                <button id="prevBtn"
                    class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition text-gray-700 text-sm font-medium flex items-center gap-1 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-chevron-left text-xs"></i> Prev
                </button>
                <div id="paginationNumbers" class="flex gap-1.5 mx-1"></div>
                <button id="nextBtn"
                    class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition text-gray-700 text-sm font-medium flex items-center gap-1 disabled:opacity-50 disabled:cursor-not-allowed">
                    Next <i class="fas fa-chevron-right text-xs"></i>
                </button>
            </div>
            <!-- Export Buttons -->
            <div class="flex gap-3 flex-col md:flex-row">
                <button id="exportPdfBtn"
                    class="bg-red-50 hover:bg-red-100 text-red-700 px-4 py-2 rounded-xl transition text-sm font-medium flex items-center gap-2 border border-red-200">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>
                <button id="exportExcelBtn"
                    class="bg-green-50 hover:bg-green-100 text-green-700 px-4 py-2 rounded-xl transition text-sm font-medium flex items-center gap-2 border border-green-200">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
                <button id="printBtn"
                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-xl transition text-sm font-medium flex items-center gap-2 shadow-sm">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>
@endsection