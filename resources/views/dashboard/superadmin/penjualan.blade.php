@extends('layouts.app-superadmin')

@section('content')
    <div class="wrapper p-6">
        <!-- HEADER -->
        <div class="flex flex-col gap-3">
            <h3 class="text-2xl font-medium">
                PENJUALAN
            </h3>
            <!-- breadcrumb -->
            <div class="flex items-center text-sm text-gray-500">
                <span class="text-lg">Penjualan</span>
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 mx-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                    <span id="pageTitle" class="text-black text-base font-semibold">
                        Kasir
                    </span>
                </span>
            </div>
        </div>
        <!-- TAB MENU -->
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-5 mt-10 border-b border-gray-200 pb-3">
            <div class="flex gap-6 items-center overflow-x-auto">
                <button onclick="showSection('kasir', 'Kasir')"
                    class="tab-btn pb-2 border-b-2 border-black font-medium cursor-pointer">
                    Kasir
                </button>
                <button onclick="showSection('transaksi', 'Penjualan')"
                    class="tab-btn pb-2 border-b-2 border-transparent text-gray-500 cursor-pointer">
                    Penjualan
                </button>
                <button onclick="showSection('detail', 'Detail Penjualan')"
                    class="tab-btn pb-2 border-b-2 border-transparent text-gray-500 cursor-pointer">
                    Detail Penjualan
                </button>
            </div>
            <div class="relative w-full md:w-64">
                <input type="text" placeholder="Search..."
                    class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
            </div>
        </div>
        <!-- SECTION KASIR -->
        <div id="kasirSection" class="mt-10">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                <!-- TITLE -->
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-xl font-semibold">Kasir</h2>
                </div>
                <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="min-w-175 w-full border-b border-gray-200">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    No
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Barang
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Qty
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Subtotal
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">1</td>
                                <td class="px-6 py-4">Indomie</td>
                                <td class="px-6 py-4">2</td>
                                <td class="px-6 py-4">6.000</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 ">
                                        <button class=" cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>
                                        <button class="cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">2</td>
                                <td class="px-6 py-4">Aqua</td>
                                <td class="px-6 py-4">1</td>
                                <td class="px-6 py-4">5.000</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 ">
                                        <button class=" cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>
                                        <button class="cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- SUMMARY -->
                <div class="mt-10 px-6 pb-6 max-w-sm ml-auto space-y-3">

                    <div class="flex justify-between">
                        <span>Total Item :</span>
                        <span>2</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total Qty :</span>
                        <span>3</span>
                    </div>
                    <div class="flex justify-between border-t pt-3 text-lg font-semibold">
                        <span>Total :</span>
                        <span>11.000</span>
                    </div>
                    <!-- BAYAR -->
                    <div class="border-t pt-6 space-y-4">
                        <div class="flex items-center justify-between gap-4">
                            <label>Bayar :</label>
                            <input type="number" placeholder="Masukan uang..."
                                class="border rounded-lg px-3 py-2 w-40 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        </div>
                        <div class="flex justify-between">
                            <span>Kembalian :</span>
                            <span>9.000</span>
                        </div>
                    </div>
                </div>
                <!-- BUTTON -->
                <div class="flex flex-col sm:flex-row justify-center gap-4 px-6 pb-6">
                    <button
                        class="w-full sm:w-auto px-8 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-xl transition cursor-pointer">
                        Reset
                    </button>
                    <button
                        class="w-full sm:w-auto px-8 py-3 bg-gray-700 hover:bg-gray-800 text-white rounded-xl transition cursor-pointer">
                        Simpan Transaksi
                    </button>
                </div>
            </div>
        </div>

        <!-- SECTION PENJUALAN -->
        <div id="transaksiSection" class="hidden mt-10">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-xl font-semibold">
                        Data Penjualan
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-200 w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    ID
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Tanggal
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Total
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Kasir
                                </th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">TRX001</td>
                                <td class="px-6 py-4">07 Mei 2026</td>
                                <td class="px-6 py-4">11.000</td>
                                <td class="px-6 py-4">Admin</td>
                                <td class="px-6 py-4">
                                    Selesai
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SECTION DETAIL -->
        <div id="detailSection" class="hidden mt-10">
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-semibold mb-6">
                    Detail Penjualan
                </h2>
                <div class="space-y-4">
                    <div class="flex justify-between border-b pb-3">
                        <span>ID Transaksi</span>
                        <span>TRX001</span>
                    </div>
                    <div class="flex justify-between border-b pb-3">
                        <span>Barang</span>
                        <span>Indomie</span>
                    </div>
                    <div class="flex justify-between border-b pb-3">
                        <span>Qty</span>
                        <span>2</span>
                    </div>
                    <div class="flex justify-between border-b pb-3">
                        <span>Total</span>
                        <span>11.000</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script src="{{ asset('js/penjualan.js') }}"></script>
@endsection