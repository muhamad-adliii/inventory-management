@extends('layouts.app-superadmin')

@section('content')
    <div class="p-6">
        <h3 class="text-xl md:text-2xl uppercase font-medium">log aktivitas</h3>
        <div class="flex capitalize font-medium mt-2">
            <span class="text-gray-500">total:
                <span class="text-black">{{ isset($auditLog) ? $auditLog->total() : 0 }}</span>
            </span>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden p-6 mt-8">
            <!-- FILTER -->
            <form action="{{ url()->current() }}" method="GET" class="flex flex-wrap items-end gap-2">
                <div class="flex flex-col gap-2">
                    <label for="q" class="text-xs text-gray-500">Cari (ID / nama / detail)</label>
                    <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="Cari..."
                        class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full md:w-56 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="aksi" class="text-xs text-gray-500">Aksi</label>
                    <select id="aksi" name="aksi"
                        class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full md:w-48">
                        <option value="">Semua aksi</option>
                        @foreach (['tambah_produk', 'hapus_produk', 'tambah_akun', 'hapus_akun', 'barang_masuk', 'barang_keluar', 'retur'] as $a)
                            <option value="{{ $a }}" @selected(request('aksi') === $a)>
                                {{ ucwords(str_replace('_', ' ', $a)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="entitas" class="text-xs text-gray-500">Entitas</label>
                    <select id="entitas" name="entitas"
                        class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full md:w-44">
                        <option value="">Semua entitas</option>
                        @foreach (['produk', 'kategori', 'supplier', 'customer', 'akun', 'transaksi_masuk', 'transaksi_keluar', 'retur'] as $e)
                            <option value="{{ $e }}" @selected(request('entitas') === $e)>
                                {{ ucwords(str_replace('_', ' ', $e)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="tanggal_awal" class="text-xs text-gray-500">Tanggal Awal</label>
                    <input type="date" id="tanggal_awal" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                        class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="tanggal_akhir" class="text-xs text-gray-500">Tanggal Akhir</label>
                    <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                        class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                </div>
                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2.5 rounded-xl transition text-sm font-medium flex items-center justify-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        Cari
                    </button>
                </div>
            </form>

            <!-- TABEL -->
            <div class="overflow-x-auto mt-8">
                <table class="min-w-250 md:min-w-full">
                    <thead>
                        <tr class="text-xs uppercase tracking-wider text-gray-800 border-b border-gray-200">
                            <th class="px-4 py-3 text-left font-semibold">No</th>
                            <th class="px-4 py-3 text-left font-semibold">Waktu</th>
                            <th class="px-4 py-3 text-left font-semibold">Pelaku</th>
                            <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                            <th class="px-4 py-3 text-left font-semibold">Entitas</th>
                            <th class="px-4 py-3 text-left font-semibold">Referensi</th>
                            <th class="px-4 py-3 text-left font-semibold">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-900">
                        @forelse ($auditLog ?? [] as $log)
                            @php
                                $warna = match (true) {
                                    str_contains($log->aksi, 'tambah') => 'bg-green-50 text-green-700',
                                    str_contains($log->aksi, 'hapus') => 'bg-red-50 text-red-700',
                                    str_contains($log->aksi, 'masuk') => 'bg-blue-50 text-blue-700',
                                    str_contains($log->aksi, 'keluar') => 'bg-amber-50 text-amber-700',
                                    str_contains($log->aksi, 'retur') => 'bg-purple-50 text-purple-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4">{{ $auditLog->firstItem() + $loop->index }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($log->tanggal)->format('d-m-Y H:i') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    {{ $log->akun->nama ?? '-' }}
                                    <span class="block text-xs text-gray-500">{{ $log->id_akun }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $warna }}">
                                        {{ ucwords(str_replace('_', ' ', $log->aksi)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    {{ ucwords(str_replace('_', ' ', $log->entitas)) }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    {{ $log->nama_referensi ?? '-' }}
                                    <span class="block text-xs text-gray-500">{{ $log->id_referensi ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-4 max-w-xs">
                                    <span
                                        title="{{ $log->detail }}">{{ \Illuminate\Support\Str::limit($log->detail, 60) ?: '-' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada aktivitas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (($auditLog ?? null) instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-6">{{ $auditLog->links() }}</div>
            @endif
        </div>
    </div>
@endsection