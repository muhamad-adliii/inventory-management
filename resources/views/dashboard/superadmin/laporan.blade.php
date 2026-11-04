@extends('layouts.app-superadmin')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-start md:items-center mb-5 flex-col md:flex-row gap-4">
            <div class="flex flex-col gap-3">
                <h3 class="text-xl md:text-2xl capitalize md:items-center gap-6 font-medium">LAPORAN</h3>
                <p class="text-gray-500 text-sm mt-1 flex items-center">
                    <i class="fas fa-calendar-alt text-indigo-400"></i>
                    Periode: 01 Mei 2026 - 07 Mei 2026
                </p>
            </div>
            <div class="bg-white/60 backdrop-blur-sm rounded-full px-4 py-1 text-sm text-gray-500 shadow-sm">
                <i class="far fa-clock mr-1"></i> Update realtime
            </div>
        </div>

        <!--  Ringkasan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <!-- Total Penjualan -->
            <div class="bg-[#e4f5ff] rounded-2xl shadow-soft p-5  card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Penjualan</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="totalPenjualanVal">Rp 2.000.000</p>
                    </div>
                    <i class="fas fa-chart-line text-emerald-400 text-3xl opacity-80"></i>
                </div>
            </div>
            <!-- Total Transaksi -->
            <div class="bg-[#f1e7ff] rounded-2xl shadow-soft p-5 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Transaksi</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="totalTransaksiVal">120</p>
                    </div>
                    <i class="fas fa-receipt text-blue-400 text-3xl opacity-80"></i>
                </div>
            </div>
            <!-- Barang Terjual -->
            <div class="bg-[#ffefe7] rounded-2xl shadow-soft p-5 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Barang Terjual</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="totalQtyVal">560 Item</p>
                    </div>
                    <i class="fas fa-boxes text-amber-400 text-3xl opacity-80"></i>
                </div>
            </div>
            <!-- Pendapatan Hari Ini -->
            <div class="bg-[#ebfdef] rounded-2xl shadow-soft p-5 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pendapatan Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1" id="pendapatanHariIniVal">Rp 500.000</p>
                    </div>
                    <i class="fas fa-coins text-indigo-400 text-3xl opacity-80"></i>
                </div>
            </div>
        </div>
        <!--  Filter & Search  -->
        <div class="bg-white rounded-2xl shadow-card p-5 md:p-6 mb-8 border border-gray-100">
            <div class="grid grid-cols-1 xl:grid-cols-3  gap-5 items-end">
                <!-- Search Laporan -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">
                        <i class="fas fa-search mr-1 text-gray-400"></i> Cari laporan
                    </label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" id="searchInput" placeholder="Invoice, barang, kasir..."
                            class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 outline-none transition bg-gray-50 focus:bg-white">
                    </div>
                </div>
                <!-- Filter Tanggal range -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">
                        <i class="fas fa-calendar-week mr-1 text-gray-400"></i> Filter tanggal
                    </label>
                    <div class="flex gap-2 items-center">
                        <div class="relative flex-1">
                            <input type="date" id="startDate" value="2026-05-01"
                                class="w-full border border-gray-200 rounded-xl py-2.5 px-3 text-sm bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-200 outline-none">
                        </div>
                        <span class="text-gray-400">—</span>
                        <div class="relative flex-1">
                            <input type="date" id="endDate" value="2026-05-07"
                                class="w-full border border-gray-200 rounded-xl py-2.5 px-3 text-sm bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-200 outline-none">
                        </div>
                    </div>
                </div>
                <!-- Status Dropdown -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">
                        <i class="fas fa-filter mr-1"></i> Status
                    </label>
                    <select id="statusFilter"
                        class="w-full border border-gray-200 rounded-xl py-2.5 px-4 bg-gray-50 focus:ring-2 focus:ring-indigo-200 outline-none cursor-pointer">
                        <option value="semua">Semua ▼</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
            </div>

            <!--  Data Laporan  -->
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
                                <th class="px-5 py-4 text-left">Invoice</th>
                                <th class="px-5 py-4 text-left">Tanggal</th>
                                <th class="px-5 py-4 text-left">Barang</th>
                                <th class="px-5 py-4 text-center">Qty</th>
                                <th class="px-5 py-4 text-left">Total</th>
                                <th class="px-5 py-4 text-left">Status</th>
                                <th class="px-5 py-4 text-left">Kasir</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-3 font-medium text-gray-700">1</td>
                                <td class="px-5 py-3 font-medium text-gray-700">TRX001</td>
                                <td class="px-5 py-3 font-medium text-gray-700">2026-05-07</td>
                                <td class="px-5 py-3 font-medium text-gray-700">Indomie</td>
                                <td class="px-5 py-3 font-medium text-gray-700">2</td>
                                <td class="px-5 py-3 font-medium text-gray-700">6000</td>
                                <td class="px-5 py-3 font-medium text-gray-700">Selesai</td>
                                <td class="px-5 py-3 font-medium text-gray-700">Admin</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--  Detail Laporan  -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
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
            class="flex flex-col md:flex-row justify-between items-center gap-5 bg-white rounded-2xl shadow-soft p-4 border border-gray-100 shadow-xl">
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