@extends('layouts.app-superadmin')

@section('content')
    <div class="p-6">
        <h3 class="text-xl md:text-2xl uppercase font-medium">Transaksi Masuk</h3>
        <div class="flex capitalize font-medium mt-2">
            <span class="text-gray-500">total: <span class="text-black">{{ $barangMasuk->count() }}</span></span>
        </div>

        @if (session('success'))
            <div class="mt-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mt-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="mt-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">{{ $errors->first() }}</div>
        @endif

        <!-- tabs -->
        <div class="flex gap-6 items-center overflow-x-auto mt-8">
            <button type="button" data-tab="formSection" class="tab-btn pb-2 border-b-2 border-black cursor-pointer">Input
                Transaksi</button>
            <button type="button" data-tab="listSection"
                class="tab-btn pb-2 border-b-2 border-transparent text-gray-500 font-medium cursor-pointer">Data Transaksi
                Masuk</button>
        </div>

        <!-- DATA -->
        <div id="listSection" class="tab-section hidden mt-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden p-6">
                <!-- FILTER -->
                <!-- FILTER -->
                <form id="formFilter" class="flex flex-wrap justify-between items-end gap-6">
                    <div class="flex flex-wrap gap-4 flex-1">
                        <!-- Filter Supplier -->
                        <div class="flex flex-col gap-2">
                            <label for="supplier" class="text-sm text-gray-500">Pengirim (Supplier)</label>
                            <input type="text" id="supplier" name="supplier" value="{{ request('supplier') }}" placeholder="Nama Pengirim"
                                class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Filter Tanggal Awal -->
                        <div class="flex flex-col gap-2">
                            <label for="tanggal_awal" class="text-sm text-gray-500">Tanggal Awal</label>
                            <input type="date" id="tanggal_awal" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                                class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full md:w-48 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Filter Tanggal Akhir -->
                        <div class="flex flex-col gap-2">
                            <label for="tanggal_akhir" class="text-sm text-gray-500">Tanggal Akhir</label>
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                                class="border border-gray-300 rounded-md px-3 py-2 text-sm w-full md:w-48 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center gap-4 pb-1 pr-4">
                        <button type="submit" class="cursor-pointer p-2 bg-blue-50 text-blue-600 rounded-full hover:bg-blue-100 transition" aria-label="Cari">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                        <a href="{{ route('superadmin.barang_masuk') }}" class="px-5 py-1.5 border border-red-300 text-red-700 text-xs rounded-full cursor-pointer hover:bg-red-50">
                            Reset
                        </a>
                    </div>
                </form>

                <!-- TABEL -->
                <div class="overflow-x-auto mt-8">
                    <table class="min-w-250 md:min-w-full">
                        <thead>
                            <tr class="text-xs uppercase tracking-wider text-gray-800">
                                <th class="px-4 py-3 text-left font-semibold">No</th>
                                <th class="px-4 py-3 text-left font-semibold">Nomor Transaksi</th>
                                <th class="px-4 py-3 text-left font-semibold">Jumlah Barang</th>
                                <th class="px-4 py-3 text-left font-semibold">Total Harga</th>
                                <th class="px-4 py-3 text-left font-semibold">Pengirim</th>
                                <th class="px-4 py-3 text-left font-semibold">Tanggal Transaksi</th>
                                <th class="px-4 py-3 text-center font-semibold">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-900">
                            @forelse ($barangMasuk as $item)
                                <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4">{{ $item->id_transaksi_masuk }}</td>
                                    <td class="px-4 py-4">
                                        {{-- Hitung total item dari relasi detail --}}
                                        {{ $item->detailTransaksiMasuk->sum('jumlah_barang') ?? 0 }}
                                        {{ $item->detailTransaksiMasuk->first()?->produk?->satuan ?? 'pcs' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        Rp. {{ number_format($item->detailTransaksiMasuk->sum('sub_total'), 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4">{{ $item->supplier->nama_supplier ?? '-' }}</td>
                                    <td class="px-4 py-4">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <button type="button" data-id="{{ $item->id_transaksi_masuk }}" data-tab="detailSection"
                                            class="btn-detail px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded cursor-pointer">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-4 text-center text-gray-500">Belum ada transaksi masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="detailSection" class="tab-section hidden mt-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h2 id="detailId" class="text-lg font-medium text-gray-900">#</h2>
                    <button type="button" data-tab="listSection"
                        class="text-l text-gray-700 hover:text-black cursor-pointer flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                        </svg>
                        Kembali
                    </button>
                </div>

                <div class="px-6 py-5">
                    <dl class="grid grid-cols-[9rem_1fr] gap-y-1.5 text-sm text-gray-800">
                        <dt>Pengirim</dt>
                        <dd id="detailSupplier">: -</dd>
                        <dt>Jumlah Barang</dt>
                        <dd id="detailJumlah">: -</dd>
                        <dt>Total Harga</dt>
                        <dd id="detailTotal">: -</dd>
                        <dt>Petugas</dt>
                        <dd id="detailPetugas">: -</dd>
                        <dt>Tanggal Transaksi</dt>
                        <dd id="detailTanggal">: -</dd>
                    </dl>

                    <!-- detail barang -->
                    <h3 class="text-sm text-gray-800 mt-8 mb-3">Detail Barang</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-200 md:min-w-full">
                            <thead>
                                <tr class="text-xs uppercase tracking-wider text-gray-800 border-b border-gray-200">
                                    <th class="px-4 py-3 text-left font-semibold">No</th>
                                    <th class="px-4 py-3 text-left font-semibold">Nama Barang</th>
                                    <th class="px-4 py-3 text-left font-semibold">Jumlah</th>
                                    <th class="px-4 py-3 text-left font-semibold">Harga Satuan</th>
                                    <th class="px-4 py-3 text-left font-semibold">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody id="detailTbody" class="text-sm text-gray-900">
                                <!-- Akan diisi oleh JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="formSection" class="tab-section mt-8">
            <form action="{{ route('barang_masuk.store') }}" method="POST" id="formTransaksi"
                class="bg-white rounded-2xl shadow p-6">
                @csrf

                <!-- HEADER TRANSAKSI -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label for="id_supplier_masuk" class="text-l text-gray-600">Supplier</label>
                        <select id="id_supplier_masuk" name="id_supplier" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Supplier --</option>
                            @foreach ($supplier as $s)
                                <option value="{{ $s->id_supplier }}">{{ $s->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="no_invoice" class="text-l text-gray-600">No. Invoice (Opsional)</label>
                        <input type="text" id="no_invoice" name="no_invoice" value="{{ old('no_invoice') }}" maxlength="50"
                            placeholder="Contoh: INV/2023/10/001"
                            class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- BARIS INPUT PRODUK -->
                <div class="grid grid-cols-2 md:grid-cols-12 gap-3 items-center mt-8">
                    <select id="inProduk"
                        class="col-span-2 md:col-span-5 border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Produk</option>
                        @foreach ($produk ?? [] as $p)
                            <option value="{{ $p->id_produk }}" data-harga="{{ $p->harga }}">{{ $p->nama_produk }}</option>
                        @endforeach
                    </select>
                    <input type="number" id="inQty" placeholder="Qty" min="1"
                        class="col-span-1 md:col-span-2 border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <input type="number" id="inHarga" readonly placeholder="Harga Satuan" min="0"
                        class="col-span-1 md:col-span-3 border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="button" id="btnTambah"
                        class="col-span-2 md:col-span-2 bg-gray-900 hover:bg-gray-700 text-white rounded-full py-2.5 text-sm font-medium cursor-pointer transition-colors">
                        Tambahkan
                    </button>
                </div>
                <p id="pesanBaris" class="text-xs text-red-600 mt-2 hidden"></p>

                <!-- TABEL ITEM -->
                <div class="overflow-x-auto mt-8">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-xs uppercase tracking-wider text-gray-700 border-b border-gray-200">
                                <th class="py-3 px-2 text-left">No</th>
                                <th class="py-3 px-2 text-left">Produk</th>
                                <th class="py-3 px-2 text-left">Qty</th>
                                <th class="py-3 px-2 text-left">Harga Satuan</th>
                                <th class="py-3 px-2 text-left">Sub Total</th>
                                <th class="py-3 px-2 text-left">Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyItem">
                            <tr id="trKosong">
                                <td colspan="6" class="py-4 text-center text-gray-500 border-b border-gray-100">Tidak ada
                                    data produk</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="border-b border-gray-100">
                                <td colspan="4" class="py-4 px-2 text-right font-semibold">Grand Total</td>
                                <td colspan="2" class="py-4 px-2 font-semibold text-lg" id="grandTotal">Rp. 0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- hidden inputs dibiarkan, JS yang akan isi -->
                <div id="hiddenInputs"></div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md cursor-pointer transition-colors">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>

        @include('partials.barang_masuk.edit')
        @include('partials.barang_masuk.hapus')
    </div>

    <script src="{{ asset('js/transaksiMasuk.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const formFilter = document.getElementById('formFilter');
        const btnReset = document.getElementById('btnResetFilter');
        const tbody = document.querySelector('#listSection tbody');

        // Fungsi Fetch Data
        async function fetchData() {
            const supplier = document.getElementById('supplier').value;
            const tglAwal = document.getElementById('tanggal_awal').value;
            const tglAkhir = document.getElementById('tanggal_akhir').value;

            // Tampilkan loading di tabel (opsional)
            tbody.innerHTML = `<tr><td colspan="7" class="py-4 text-center text-gray-500">Memuat data...</td></tr>`;

            // Bikin URL parameter
            const params = new URLSearchParams({
                supplier: supplier,
                tanggal_awal: tglAwal,
                tanggal_akhir: tglAkhir
            });

            try {
                // Tembak ke URL dengan parameter
                const response = await fetch(`{{ route('superadmin.barang_masuk') }}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const html = await response.text();
                
                // Parsing HTML response untuk ngambil isi tbody doang
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTbody = doc.querySelector('#listSection tbody').innerHTML;

                // Timpa tabel lama dengan yang baru
                tbody.innerHTML = newTbody;
                
                // Bind ulang event listener ke tombol detail yang baru
                bindDetailButtons();

            } catch (error) {
                console.error(error);
                tbody.innerHTML = `<tr><td colspan="7" class="py-4 text-center text-red-500">Gagal mengambil data.</td></tr>`;
            }
        }

        // Event saat tombol cari diklik
        formFilter.addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah reload halaman
            fetchData();
        });

        // Event saat input tanggal diganti (Auto filter)
        document.getElementById('tanggal_awal').addEventListener('change', fetchData);
        document.getElementById('tanggal_akhir').addEventListener('change', fetchData);

        // Event tombol reset
        btnReset.addEventListener('click', function() {
            document.getElementById('supplier').value = '';
            document.getElementById('tanggal_awal').value = '';
            document.getElementById('tanggal_akhir').value = '';
            fetchData();
        });

        // (Opsional) Bikin tombol detail tetep jalan setelah filter
        function bindDetailButtons() {
            // Kalau fungsi detail lo ada di file terpisah, panggil ulang inisialisasinya di sini
            // Kalau fungsi detail lo pake onclick inline, abaikan ini.
        }
    });
    </script>
@endsection