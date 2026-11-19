@extends('layouts.app-superadmin')

@section('content')
    <div class="p-6">
        <h3 class="text-xl md:text-2xl uppercase font-medium">Transaksi Keluar</h3>

        @if (session('success'))
        <div class="mt-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">{{ session('success') }}</div> @endif
        @if (session('error'))
        <div class="mt-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">{{ session('error') }}</div> @endif

        <div class="flex gap-6 items-center overflow-x-auto mt-8">
            <button type="button" data-tab="formSection" class="tab-btn pb-2 border-b-2 border-black cursor-pointer">Input
                Transaksi</button>
            <button type="button" data-tab="listSection"
                class="tab-btn pb-2 border-b-2 border-transparent text-gray-500 font-medium cursor-pointer">Data Transaksi
                Keluar</button>
        </div>

        <div id="formSection" class="tab-section mt-6 bg-white rounded-2xl shadow p-6">
            <form action="{{ route('transaksi_keluar.store') }}" method="POST" id="formTransaksiKeluar">
                @csrf
                <!-- HEADER -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm text-gray-600">Customer</label>
                        <select name="id_customer" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Customer --</option>
                            @foreach ($customer as $c)
                                <option value="{{ $c->id_customer }}">{{ $c->nama_customer }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="flex flex-col gap-2">
                                                                                        <label class="text-sm text-gray-600">No. Invoice (Opsional)</label>
                                                                                        <input type="text" name="no_invoice" placeholder="Contoh: INV/2023/10/001" maxlength="50"
                                                                                            class="border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                                                                                    </div> -->
                </div>

                <!-- INPUT PRODUK -->
                <div class="grid grid-cols-2 md:grid-cols-12 gap-3 items-center mt-8">
                    <select id="inProdukKeluar"
                        class="col-span-2 md:col-span-5 border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-600">
                        <option value="">Pilih Produk</option>
                        @foreach ($produk ?? [] as $p)
                            <option value="{{ $p->id_produk }}" data-harga="{{ $p->harga }}" data-stok="{{ $p->stok }}"
                                data-satuan="{{ $p->satuan }}">
                                {{ $p->nama_produk }}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" id="inQtyKeluar" placeholder="Qty" min="1"
                        class="col-span-1 md:col-span-2 border border-gray-300 rounded-lg px-3 py-2.5 text-sm">

                    <!-- Readonly Stok & Harga -->
                    <input type="text" id="inStokKeluar" readonly placeholder="Stok"
                        class="col-span-1 md:col-span-2 border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-gray-100 cursor-not-allowed">
                    <input type="number" id="inHargaKeluar" readonly placeholder="Harga"
                        class="col-span-2 md:col-span-2 border border-gray-300 rounded-lg px-3 py-2.5 text-sm bg-gray-100 cursor-not-allowed">

                    <button type="button" id="btnTambahKeluar"
                        class="col-span-2 md:col-span-1 bg-gray-900 hover:bg-gray-700 text-white rounded-md py-2.5 text-xs font-medium cursor-pointer transition-colors">
                        Tambahkan
                    </button>
                </div>
                <p id="pesanBarisKeluar" class="text-xs text-red-600 mt-2 hidden"></p>

                <!-- TABEL -->
                <div class="overflow-x-auto mt-8">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-xs uppercase tracking-wider text-gray-700 border-b border-gray-200">
                                <th class="py-3 px-2 text-left">No</th>
                                <th class="py-3 px-2 text-left">Produk</th>
                                <th class="py-3 px-2 text-left">Qty</th>
                                <th class="py-3 px-2 text-left">Harga</th>
                                <th class="py-3 px-2 text-left">Sub Total</th>
                                <th class="py-3 px-2 text-left">Opsi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyItemKeluar">
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">Tidak ada data produk</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="border-b border-gray-100">
                                <td colspan="4" class="py-4 px-2 text-right font-semibold">Grand Total</td>
                                <td colspan="2" class="py-4 px-2 font-semibold text-lg" id="grandTotalKeluar">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div id="hiddenInputsKeluar"></div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
        <div id="listSection" class="tab-section hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-250 md:min-w-full">
                        <thead>
                            <tr class="text-xs uppercase tracking-wider text-gray-800">
                                <th class="px-4 py-3 text-left font-semibold">No</th>
                                <th class="px-4 py-3 text-left font-semibold">Nomor Transaksi</th>
                                <th class="px-4 py-3 text-left font-semibold">Jumlah Barang</th>
                                <th class="px-4 py-3 text-left font-semibold">Total Harga</th>
                                <th class="px-4 py-3 text-left font-semibold">Customer</th>
                                <th class="px-4 py-3 text-left font-semibold">Tanggal Transaksi</th>
                                <th class="px-4 py-3 text-center font-semibold">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-900">
                            @forelse ($transaksiKeluar ?? [] as $item)
                                <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-4">{{ $item->id_transaksi_keluar }}</td>
                                    <td class="px-4 py-4">{{ $item->detailTransaksiKeluar->sum('jumlah_barang') }}</td>
                                    <td class="px-4 py-4">Rp.
                                        {{ number_format($item->detailTransaksiKeluar->sum('total_harga'), 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4">{{ $item->customer->nama_customer ?? '-' }}</td>
                                    <td class="px-4 py-4">
                                        <dd> {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</dd>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <button type="button" data-tab="detailKeluar{{ $item->id_transaksi_keluar }}"
                                            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded cursor-pointer">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @foreach ($transaksiKeluar ?? [] as $item)
            <div id="detailKeluar{{ $item->id_transaksi_keluar }}" class="tab-section hidden mt-6">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">#{{ $item->id_transaksi_keluar }}</h2>
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
                            <dt>Customer</dt>
                            <dd>: {{ $item->customer->nama_customer ?? '-' }}</dd>
                            <dt>Kontak</dt>
                            <dd>: {{ $item->customer->no_telp ?? '-' }}</dd>
                            <dt>Alamat</dt>
                            <dd>: {{ $item->customer->alamat ?? '-' }}</dd>
                            <dt>Jumlah Barang</dt>
                            <dd>: {{ $item->detailTransaksiKeluar->sum('jumlah_barang') }}</dd>
                            <dt>Total Harga</dt>
                            <dd>: Rp. {{ number_format($item->detailTransaksiKeluar->sum('total_harga'), 0, ',', '.') }}</dd>
                            <dt>Petugas</dt>
                            <dd>: {{ $item->akun->nama ?? '-' }}</dd>
                            <dt>Tanggal Transaksi</dt>
                            <dd>: {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</dd>
                        </dl>

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
                                <tbody class="text-sm text-gray-900">
                                    @foreach ($item->detailTransaksiKeluar as $d)
                                        <tr class="border-b border-gray-100">
                                            <td class="px-4 py-4">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-4">{{ $d->produk->nama_produk ?? '-' }}</td>
                                            <td class="px-4 py-4">{{ $d->jumlah_barang }} {{ $d->produk->satuan ?? '' }}</td>
                                            <td class="px-4 py-4">Rp. {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                                            <td class="px-4 py-4">Rp. {{ number_format($d->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script src="{{ asset('js/transaksiKeluar.js') }}"></script>
@endsection