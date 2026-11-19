@extends('layouts.app-admin')

@section('content')
    <div class="wrapper-barang p-6">
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-5">
            <div class="flex flex-col gap-3">
                <h3 class="text-header text-xl md:text-2xl uppercase font-medium">Produk</h3>
                <div class="flex capitalize font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 mr-1 text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                    </svg>
                    <span class="text-gray-500">total: <span class="text-black">{{ $produk->count() }}</span></span>
                </div>
            </div>
        </div>
        <!-- pagination & search -->
        <div class="mt-10">
            <div class="mx-auto">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- header -->
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                        <div class="text-header">
                            <h2 class="text-base font-semibold text-gray-800">Tabel Produk</h2>
                        </div>
                        <div class="relative">
                            <input type="text" placeholder="Search"
                                class="border border-gray-300 rounded-md pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full md:w-64">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-4 h-4 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <!-- Table 1 -->
                    <div class="overflow-x-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-4">
                            @foreach ($produk as $item)
                                <div
                                    class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden relative hover:shadow-lg transition-shadow duration-300">

                                    <!-- Bagian Gambar & Badge Kategori -->
                                    <div class="relative h-48 bg-gray-100 flex items-center justify-center">
                                        @if ($item->path_gambar)
                                            <img src="{{ asset('storage/' . $item->path_gambar) }}"
                                                class="w-full h-full object-contain" alt="{{ $item->nama_produk }}">
                                        @else
                                            <span class="text-gray-400 text-sm italic">Tidak ada gambar</span>
                                        @endif

                                        <!-- Badge Kategori -->
                                        <span
                                            class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">
                                            {{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                                        </span>
                                    </div>

                                    <!-- Konten Card -->
                                    <div class="p-5">
                                        <!-- Nama Produk & Tombol Titik 3 -->
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-800 line-clamp-1">
                                                    {{ $item->nama_produk }}</h3>
                                                <p class="text-xs text-gray-500">ID: {{ $item->id_produk }}</p>
                                            </div>
                                        </div>

                                        <!-- Deskripsi Singkat -->
                                        <p class="text-sm text-gray-600 mb-4 line-clamp-2 h-10">
                                            {{ Str::limit($item->deskripsi, 60) }}</p>

                                        <!-- Info Harga & Stok -->
                                        <div class="flex justify-between items-center mb-4">
                                            <div class="text-xl font-extrabold text-blue-600">
                                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                                            </div>
                                            <div class="text-sm font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded">
                                                Stok: {{ $item->stok }} {{ $item->satuan }}
                                            </div>
                                        </div>

                                        <!-- Footer Card (Rak & Supplier) -->
                                        <div class="border-t border-gray-100 pt-3 flex flex-col gap-1 text-xs text-gray-500">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                    </path>
                                                </svg>
                                                <span>Rak: <strong
                                                        class="text-gray-700">{{ $item->lokasi_rak ?? '-' }}</strong></span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                                <span>Supplier: <strong
                                                        class="text-gray-700">{{ $item->supplier->nama_supplier ?? '-' }}</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Script buat Dropdown Titik 3 -->
                        <script>
                            function toggleDropdown(id) {
                                // Sembunyikan semua dropdown lain dulu biar rapi
                                document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                                    if (el.id !== id) el.classList.add('hidden');
                                });

                                // Toggle dropdown yang diklik
                                const dropdown = document.getElementById(id);
                                dropdown.classList.toggle('hidden');
                            }

                            // Tutup dropdown kalau user klik di luar area dropdown
                            window.addEventListener('click', function (e) {
                                if (!e.target.closest('.relative')) {
                                    document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                                        el.classList.add('hidden');
                                    });
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection