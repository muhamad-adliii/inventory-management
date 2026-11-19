@extends('layouts.app-admin')

@section('content')
    <div class="p-6">
        <h3 class="text-xl md:text-2xl uppercase font-medium">Retur Barang ke Supplier</h3>

        @if (session('success'))
            <div class="mt-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mt-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm">{{ session('error') }}</div>
        @endif

        <div class="flex gap-6 items-center overflow-x-auto mt-8">
            <button type="button" data-tab="formSection" class="tab-btn pb-2 border-b-2 border-black cursor-pointer">
                Input Retur Barang
            </button>
            <button type="button" data-tab="listSection"
                class="tab-btn pb-2 border-b-2 border-transparent text-gray-500 font-medium cursor-pointer">
                Data Retur Barang
            </button>
        </div>

        {{-- ===== TAB 1: FORM ===== --}}
        <div id="formSection" class="tab-section mt-6 bg-white rounded-2xl shadow p-6">
            <form action="{{ route('retur.store') }}" method="POST" enctype="multipart/form-data" id="formRetur">
                @csrf

                <div class="flex flex-col gap-2 mb-6">
                    <label class="text-sm text-gray-600">Pilih ID Transaksi Masuk :</label>
                    <select id="selectTransaksi" name="id_transaksi_masuk" required
                        class="w-full md:w-1/2 border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Transaksi --</option>
                        @foreach ($transaksiMasuk as $tm)
                            <option value="{{ $tm->id_transaksi_masuk }}">
                                {{ $tm->id_transaksi_masuk }} ({{ $tm->supplier->nama_supplier ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="areaDetail" class="hidden border-t border-gray-200 pt-6">
                    <dl class="grid grid-cols-[9rem_1fr] gap-y-1.5 text-sm text-gray-800 mb-6">
                        <dt>Supplier</dt>
                        <dd id="detailSupplier">: -</dd>
                        <dt>Petugas</dt>
                        <dd id="detailPetugas">: -</dd>
                        <dt>Tanggal</dt>
                        <dd id="detailTanggal">: -</dd>
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
                            <tbody id="tbodyDetail"></tbody>
                        </table>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 border-t border-gray-200 pt-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-sm text-gray-600">Alasan Retur :</label>
                            <textarea name="alasan" required rows="3" placeholder="Contoh: Barang rusak saat pengiriman"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-sm text-gray-600">Dokumentasi (Foto Bukti) :</label>
                            <input type="file" name="dokumentasi" accept="image/*"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-gray-800 file:px-3 file:py-1 file:text-white">
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md">
                            Ajukan Retur
                        </button>
                    </div>
                </div>
            </form>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-250 md:min-w-full">
                        <thead>
                            <tr class="text-xs uppercase tracking-wider text-gray-800">
                                <th class="px-4 py-3 text-left font-semibold">No</th>
                                <th class="px-4 py-3 text-left font-semibold">ID Retur</th>
                                <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold">Jumlah Barang</th>
                                <th class="px-4 py-3 text-left font-semibold">Alasan</th>
                                <th class="px-4 py-3 text-left font-semibold">Status</th>
                                <!-- <th class="px-4 py-3 text-center font-semibold">Aksi</th> -->
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-900">
                            @forelse ($retur as $r)
                                                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                                                        <td class="px-4 py-4">{{ $loop->iteration }}</td>
                                                        <td class="px-4 py-4">{{ $r->id_retur }}</td>
                                                        <td class="px-4 py-4">{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
                                                        <td class="px-4 py-4">{{ $r->detailRetur->sum('jumlah_retur') }}</td>
                                                        <td class="px-4 py-4">{{ Str::limit($r->alasan, 30) }}</td>
                                                        <td class="px-4 py-4 uppercase text-xs font-bold
                                                                                                                                                                                                                                                                        {{ match ($r->status_retur) {
                                    'approved' => 'text-green-600',
                                    'rejected' => 'text-red-600',
                                    default => 'text-yellow-600',
                                } }}">
                                                            {{ $r->status_retur }}
                                                        </td>
                                                        <!-- <td class="px-4 py-4 w-px whitespace-nowrap">
                                                                                                                                                                                                        <div class="flex justify-center gap-2">
                                                                                                                                                                                                            @if ($r->status_retur === 'pending')
                                                                                                                                                                                                                <button type="button" data-aksi="approved" data-id="{{ $r->id_retur }}"
                                                                                                                                                                                                                    data-url="{{ route('retur.update_status', $r->id_retur) }}"
                                                                                                                                                                                                                    class="btn-aksi-retur px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs rounded cursor-pointer">
                                                                                                                                                                                                                    Approve
                                                                                                                                                                                                                </button>
                                                                                                                                                                                                                <button type="button" data-aksi="rejected" data-id="{{ $r->id_retur }}"
                                                                                                                                                                                                                    data-url="{{ route('retur.update_status', $r->id_retur) }}"
                                                                                                                                                                                                                    class="btn-aksi-retur px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded cursor-pointer">
                                                                                                                                                                                                                    Reject
                                                                                                                                                                                                                </button>
                                                                                                                                                                                                            @endif
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                    </td> -->
                                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada data retur.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="listSection" class="tab-section hidden mt-6">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-250 md:min-w-full">
                        <thead>
                            <tr class="text-xs uppercase tracking-wider text-gray-800">
                                <th class="px-4 py-3 text-left font-semibold">No</th>
                                <th class="px-4 py-3 text-left font-semibold">ID Retur</th>
                                <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold">Jumlah Barang</th>
                                <th class="px-4 py-3 text-left font-semibold">Alasan</th>
                                <th class="px-4 py-3 text-left font-semibold">Status</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-900">
                            @forelse ($retur as $r)
                                                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition-colors">
                                                        <td class="px-4 py-4">{{ $loop->iteration }}</td>
                                                        <td class="px-4 py-4">{{ $r->id_retur }}</td>
                                                        <td class="px-4 py-4">{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
                                                        <td class="px-4 py-4">{{ $r->detailRetur->sum('jumlah_retur') }}</td>
                                                        <td class="px-4 py-4">{{ Str::limit($r->alasan, 30) }}</td>
                                                        <td class="px-4 py-4 uppercase text-xs font-bold
                                                                                                                                                                                                                                                                        {{ match ($r->status_retur) {
                                    'approved' => 'text-green-600',
                                    'rejected' => 'text-red-600',
                                    default => 'text-yellow-600',
                                } }}">
                                                            {{ $r->status_retur }}
                                                        </td>
                                                        <td class="px-4 py-4 w-px whitespace-nowrap">
                                                            <div class="flex justify-center gap-2">
                                                                <button type="button" data-tab="detailRetur{{ $r->id_retur }}"
                                                                    class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded cursor-pointer">
                                                                    Detail
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada data retur.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @foreach ($retur as $r)
            @php
                $first = $r->detailRetur->first();
                $supplier = $first?->transaksiMasuk?->supplier;
            @endphp
            <div id="detailRetur{{ $r->id_retur }}" class="tab-section hidden mt-6">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                        <h2 id="detailId" class="text-lg font-medium text-gray-900">#{{ $r->id_retur }}</h2>
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
                            <dt>Transaksi Masuk</dt>
                            <dd>: {{ $first->id_transaksi_masuk ?? '-' }}</dd>
                            <dt>Supplier</dt>
                            <dd>: {{ $supplier->nama_supplier ?? '-' }}</dd>
                            <dt>Petugas</dt>
                            <dd>: {{ $r->akun->nama ?? '-' }}</dd>
                            <dt>Tanggal</dt>
                            <dd>: {{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</dd>
                            <dt>Jumlah Barang</dt>
                            <dd>: {{ $r->detailRetur->sum('jumlah_retur') }}</dd>
                            <dt>Alasan</dt>
                            <dd>: {{ $r->alasan }}</dd>
                            <dt>Status</dt>
                            <dd class="uppercase text-xs font-bold
                                                                                                {{ match ($r->status_retur) {
                'approved' => 'text-green-600',
                'rejected' => 'text-red-600',
                default => 'text-yellow-600',
            } }}">: {{ $r->status_retur }}</dd>
                        </dl>

                        @if ($r->dokumentasi_path)
                            <h3 class="text-sm text-gray-800 mt-8 mb-3">Dokumentasi</h3>
                            <a href="{{ asset('storage/' . $r->dokumentasi_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $r->dokumentasi_path) }}" alt="Bukti retur"
                                    class="max-w-xs rounded-lg border border-gray-200">
                            </a>
                        @endif

                        <h3 class="text-sm text-gray-800 mt-8 mb-3">Detail Barang</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-200 md:min-w-full">
                                <thead>
                                    <tr class="text-xs uppercase tracking-wider text-gray-800 border-b border-gray-200">
                                        <th class="px-4 py-3 text-left font-semibold">No</th>
                                        <th class="px-4 py-3 text-left font-semibold">Nama Barang</th>
                                        <th class="px-4 py-3 text-left font-semibold">Jumlah Retur</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm text-gray-900">
                                    @foreach ($r->detailRetur as $d)
                                        <tr class="border-b border-gray-100">
                                            <td class="px-4 py-4">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-4">{{ $d->produk->nama_produk ?? '-' }}</td>
                                            <td class="px-4 py-4">{{ $d->jumlah_retur }} {{ $d->produk->satuan ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @include('partials.retur.aksi')
    </div>

    <script src="{{ asset('js/retur.js') }}"></script>
@endsection