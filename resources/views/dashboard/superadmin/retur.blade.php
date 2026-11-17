@extends('layouts.app-superadmin')

@section('content')
<div class="p-6">
    <h3 class="text-xl md:text-2xl uppercase font-medium mb-6">Retur Barang ke Supplier</h3>

    @if (session('success')) <div class="mt-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">{{ session('success') }}</div> @endif
    @if (session('error')) <div class="mt-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">{{ session('error') }}</div> @endif

    <div class="bg-white rounded-2xl shadow p-6">
        <form action="{{ route('retur.store') }}" method="POST" enctype="multipart/form-data" id="formRetur">
            @csrf

            <!-- PILIH TRANSAKSI MASUK -->
            <div class="flex flex-col gap-2 mb-6">
                <label class="text-sm text-gray-600">Pilih ID Transaksi Masuk :</label>
                <select id="selectTransaksi" name="id_transaksi_masuk" required class="w-full md:w-1/2 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Transaksi --</option>
                    @foreach ($transaksiMasuk as $tm)
                        <option value="{{ $tm->id_transaksi_masuk }}">{{ $tm->id_transaksi_masuk }} ({{ $tm->supplier->nama_supplier ?? '-' }})</option>
                    @endforeach
                </select>
            </div>

            <!-- AREA DETAIL (Muncul kalau transaksi dipilih) -->
            <div id="areaDetail" class="hidden border-t border-gray-200 pt-6">
                
                <!-- Info Transaksi -->
                <dl class="grid grid-cols-[9rem_1fr] gap-y-1.5 text-sm text-gray-800 mb-6">
                    <dt>Supplier</dt> <dd id="detailSupplier">: -</dd>
                    <dt>Petugas</dt> <dd id="detailPetugas">: -</dd>
                    <dt>Tanggal</dt> <dd id="detailTanggal">: -</dd>
                </dl>

                <h3 class="text-sm font-semibold text-gray-800 mb-3">Pilih Barang yang Diretur:</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-xs uppercase tracking-wider text-gray-700 border-b border-gray-200">
                                <th class="py-3 px-2 text-left">Produk</th>
                                <th class="py-3 px-2 text-left">Qty Masuk</th>
                                <th class="py-3 px-2 text-left">Jumlah Retur</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyDetail">
                            <!-- Diisi via JS -->
                        </tbody>
                    </table>
                </div>

                <!-- Input Alasan & Dokumentasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 border-t border-gray-200 pt-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm text-gray-600">Alasan Retur :</label>
                        <textarea name="alasan" required rows="3" placeholder="Contoh: Barang rusak saat pengiriman" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm text-gray-600">Dokumentasi (Foto Bukti) :</label>
                        <input type="file" name="dokumentasi" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-gray-800 file:px-3 file:py-1 file:text-white">
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md">Ajukan Retur</button>
                </div>
            </div>
        </form>
    </div>

    <!-- TABEL HISTORY RETUR -->
    <div class="mt-8 bg-white rounded-2xl shadow p-6">
        <h3 class="text-lg font-medium mb-4">Riwayat Retur</h3>
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-xs uppercase tracking-wider text-gray-700 border-b border-gray-200">
                    <th class="py-3 px-2 text-left">ID Retur</th>
                    <th class="py-3 px-2 text-left">Tanggal</th>
                    <th class="py-3 px-2 text-left">Alasan</th>
                    <th class="py-3 px-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($retur as $r)
                    <tr class="border-b border-gray-100">
                        <td class="py-3 px-2">{{ $r->id_retur }}</td>
                        <td class="py-3 px-2">{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td>
                        <td class="py-3 px-2">{{ Str::limit($r->alasan, 30) }}</td>
                        <td class="py-3 px-2 uppercase text-xs font-bold text-yellow-600">{{ $r->status_retur }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-4 text-center text-gray-500">Belum ada data retur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="{{ asset('js/retur.js') }}"></script>
@endsection