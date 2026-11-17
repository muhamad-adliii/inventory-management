@extends('layouts.app-superadmin')

@section('content')
<div class="p-6">
    <h3 class="text-xl md:text-2xl uppercase font-medium">Transaksi Keluar</h3>

    @if (session('success')) <div class="mt-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">{{ session('success') }}</div> @endif
    @if (session('error')) <div class="mt-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">{{ session('error') }}</div> @endif

    <div class="mt-6 bg-white rounded-2xl shadow p-6">
        <form action="{{ route('transaksi_keluar.store') }}" method="POST" id="formTransaksiKeluar">
            @csrf

            <!-- HEADER -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-2">
                    <label class="text-sm text-gray-600">Customer</label>
                    <select name="id_customer" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
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
                <select id="inProdukKeluar" class="col-span-2 md:col-span-5 border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-600">
                    <option value="">Pilih Produk</option>
                    @foreach ($produk ?? [] as $p)
                        <option value="{{ $p->id_produk }}" data-harga="{{ $p->harga }}" data-stok="{{ $p->stok }}" data-satuan="{{ $p->satuan }}">
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
                    class="col-span-2 md:col-span-1 bg-gray-900 hover:bg-gray-700 text-white rounded-full py-2.5 text-sm font-medium">
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
                        <tr><td colspan="6" class="py-4 text-center text-gray-500">Tidak ada data produk</td></tr>
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
</div>

<script src="{{ asset('js/transaksiKeluar.js') }}"></script>
@endsection