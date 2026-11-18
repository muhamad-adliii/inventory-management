@extends('layouts.app-superadmin')

@section('content')
    @php
        $rp = fn($v) => 'Rp ' . number_format((float) $v, 0, ',', '.');
        $angka = fn($v) => number_format((float) $v, 0, ',', '.');
    @endphp

    <div class="p-6">
        <div class="flex justify-between items-start md:items-center mb-5 flex-col md:flex-row gap-4">
            <div class="flex flex-col gap-3">
                <h3 class="text-xl md:text-2xl capitalize md:items-center gap-6 font-medium uppercase">LAPORAN {{ $meta['nama'] }}
                </h3>
                <p class="text-gray-500 text-sm mt-1 flex items-center gap-1">
                    <i class="fas fa-calendar-alt text-indigo-400"></i>
                    Periode: {{ \Carbon\Carbon::parse($mulai)->locale('id')->translatedFormat('d F Y') }}
                    - {{ \Carbon\Carbon::parse($selesai)->locale('id')->translatedFormat('d F Y') }}
                </p>
            </div>
            <div class="bg-white/60 backdrop-blur-sm rounded-full px-4 py-1 text-sm text-gray-500 shadow-sm">
                <i class="far fa-clock mr-1"></i> Update realtime
            </div>
        </div>

        <!--  Ringkasan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-[#e4f5ff] rounded-2xl shadow-soft p-5 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ $meta['total'] }}</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $rp($ringkas->total) }}</p>
                    </div>
                    <i class="fas fa-chart-line text-emerald-400 text-3xl opacity-80"></i>
                </div>
            </div>
            <div class="bg-[#f1e7ff] rounded-2xl shadow-soft p-5 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ $meta['trx'] }}</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $angka($ringkas->transaksi) }}</p>
                    </div>
                    <i class="fas fa-receipt text-blue-400 text-3xl opacity-80"></i>
                </div>
            </div>
            <div class="bg-[#ffefe7] rounded-2xl shadow-soft p-5 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ $meta['qty'] }}</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $angka($ringkas->qty) }} Item</p>
                    </div>
                    <i class="fas fa-boxes text-amber-400 text-3xl opacity-80"></i>
                </div>
            </div>
            <div class="bg-[#ebfdef] rounded-2xl shadow-soft p-5 card-hover">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">{{ $meta['hari'] }}</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $rp($hariIni) }}</p>
                    </div>
                    <i class="fas fa-coins text-indigo-400 text-3xl opacity-80"></i>
                </div>
            </div>
        </div>

        <!--  Filter & Data  -->
        <div class="bg-white rounded-2xl shadow-card p-5 md:p-6 mb-8 border border-gray-300">
            <form method="GET" action="{{ url()->current() }}"
                class="grid grid-cols-1 xl:grid-cols-[2fr_2.4fr_1.4fr_auto] gap-5 items-end">
                <div>
                    <label for="q" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">
                        <i class="fas fa-search mr-1 text-gray-400"></i> Cari laporan
                    </label>
                    <div class="relative">
                        <input type="text" name="q" id="q" value="{{ $q }}"
                            placeholder="Kode, produk, {{ strtolower($meta['pihak']) }}, admin..."
                            class="w-full pl-5 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 outline-none transition bg-gray-50 focus:bg-white">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">
                        <i class="fas fa-calendar-week mr-1 text-gray-400"></i> Filter tanggal
                    </label>
                    <div class="flex gap-2 items-center">
                        <input type="date" name="mulai" value="{{ $mulai }}" aria-label="Tanggal mulai"
                            class="w-full flex-1 border border-gray-200 rounded-xl py-2.5 px-3 text-sm bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-200 outline-none">
                        <span class="text-gray-400">—</span>
                        <input type="date" name="selesai" value="{{ $selesai }}" aria-label="Tanggal selesai"
                            class="w-full flex-1 border border-gray-300 rounded-xl py-2.5 px-3 text-sm bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-200 outline-none">
                    </div>
                </div>

                <div>
                    <label for="jenis" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">
                        <i class="fas fa-filter mr-1"></i> Jenis laporan
                    </label>
                    <select name="jenis" id="jenis"
                        class="w-full border border-gray-300 rounded-xl py-2 px-4 bg-gray-50 focus:ring-2 focus:ring-indigo-200 outline-none cursor-pointer">
                        <option value="penjualan" @selected($jenis === 'penjualan')>Penjualan</option>
                        <option value="masuk" @selected($jenis === 'masuk')>Barang Masuk</option>
                        <option value="retur" @selected($jenis === 'retur')>Retur</option>
                    </select>
                </div>

                <button type="submit"
                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2.5 rounded-xl transition text-sm font-medium flex items-center justify-center gap-2 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    Cari
                </button>
            </form>

            <!--  Data Laporan  -->
            <div class="bg-white rounded-2xl shadow-card overflow-hidden border border-gray-300 mt-6">
                <div class="px-6 py-4 border-b border-gray-400  bg-gray-50/80 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                    </svg>
                    <h2 class="font-semibold text-gray-700 text-lg">Data Laporan</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wider">
                            <tr>
                                <th class="px-5 py-4 text-left">No</th>
                                <th class="px-5 py-4 text-left">Kode</th>
                                <th class="px-5 py-4 text-left">Tanggal</th>
                                <th class="px-5 py-4 text-left">Barang</th>
                                <th class="px-5 py-4 text-center">Qty</th>
                                <th class="px-5 py-4 text-left">Total</th>
                                <th class="px-5 py-4 text-left">{{ $meta['pihak'] }}</th>
                                <th class="px-5 py-4 text-left">Admin</th>
                                @if ($jenis === 'retur')
                                    <th class="px-5 py-4 text-left">Alasan</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($rows as $row)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-5 py-3 font-medium text-gray-700">{{ $rows->firstItem() + $loop->index }}</td>
                                    <td class="px-5 py-3 font-medium text-gray-700 whitespace-nowrap">{{ $row->kode }}</td>
                                    <td class="px-5 py-3 text-gray-700 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-5 py-3 text-gray-700">{{ $row->produk }}</td>
                                    <td class="px-5 py-3 text-gray-700 text-center">{{ $angka($row->qty) }}</td>
                                    <td class="px-5 py-3 text-gray-700 whitespace-nowrap">{{ $rp($row->total) }}</td>
                                    <td class="px-5 py-3 text-gray-700">{{ $row->pihak }}</td>
                                    <td class="px-5 py-3 text-gray-700">{{ $row->admin }}</td>
                                    @if ($jenis === 'retur')
                                        <td class="px-5 py-3 text-gray-700">{{ $row->keterangan }}</td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $jenis === 'retur' ? 9 : 8 }}" class="px-5 py-12 text-center text-gray-500">
                                        Tidak ada data pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--  Detail Laporan  -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div
                class="bg-linear-to-br from-white to-gray-50 rounded-2xl shadow-soft p-5 flex items-center justify-between border border-gray-300 shadow-xl">
                <div>
                    <p class="text-gray-500 text-sm">Jenis Produk</p>
                    <p class="text-3xl font-black text-gray-800">{{ $angka($detail->item) }}</p>
                </div>
                <i class="fas fa-tags text-indigo-300 text-4xl"></i>
            </div>
            <div
                class="bg-linear-to-br from-white to-gray-50 rounded-2xl shadow-soft p-5 flex items-center justify-between border border-gray-300 shadow-xl">
                <div>
                    <p class="text-gray-500 text-sm">Total Qty</p>
                    <p class="text-3xl font-black text-gray-800">{{ $angka($detail->qty) }}</p>
                </div>
                <i class="fas fa-cubes text-emerald-300 text-4xl"></i>
            </div>
            <div
                class="bg-linear-to-br from-white to-gray-50 rounded-2xl shadow-soft p-5 flex items-center justify-between border border-gray-300 shadow-xl">
                <div>
                    <p class="text-gray-500 text-sm">Total Nilai</p>
                    <p class="text-3xl font-black text-gray-800">{{ $rp($detail->total) }}</p>
                </div>
                <i class="fas fa-money-bill-wave text-amber-400 text-4xl"></i>
            </div>
        </div>

        <!-- PAGINATION & EXPORT  -->
        <div
            class="flex flex-col md:flex-row justify-between items-center gap-5 bg-white rounded-2xl shadow-soft p-4 border border-gray-100 shadow-xl">
            <div>{{ $rows->links() }}</div>

            <div class="flex gap-3 flex-col md:flex-row">
                <a href="{{ request()->fullUrlWithQuery(['export' => 1]) }}"
                    class="bg-green-50 hover:bg-green-100 text-green-700 px-4 py-2 rounded-xl transition text-sm font-medium flex items-center justify-center gap-2 border border-green-200">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
                <button type="button" onclick="window.print()"
                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-xl transition text-sm font-medium flex items-center justify-center gap-2 shadow-sm cursor-pointer">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>
@endsection