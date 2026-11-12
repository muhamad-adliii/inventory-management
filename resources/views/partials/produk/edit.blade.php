@foreach ($produk as $item)
    <div id="editBarangModal{{ $item->id_produk }}"
        class="hidden fixed inset-0 bg-black/40 z-20 items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto mt-20 mb-5">
            <!-- header -->
            <div class="flex justify-between items-center mb-8">
                <h2 class="font-medium text-lg md:text-xl">Edit Produk</h2>
                <button type="button" data-close-modal="editBarangModal{{ $item->id_produk }}" class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- form -->
            <form action="{{ route('produk.update', $item->id_produk) }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf
                @method('PUT')

                <div class="flex flex-col gap-2">
                    <label for="nama_produk_{{ $item->id_produk }}" class="text-base">Nama Produk :</label>
                    <input type="text" id="nama_produk_{{ $item->id_produk }}" name="nama_produk"
                        value="{{ $item->nama_produk }}" required maxlength="100"
                        class="w-full border rounded-xl px-4 py-2">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-base">Kategori :</label>
                    <select name="id_kategori" required class="w-full border rounded-xl px-4 py-2">
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id_kategori }}" @selected($item->id_kategori === $k->id_kategori)>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-base">Supplier :</label>
                    <select name="id_supplier" required class="w-full border rounded-xl px-4 py-2">
                        @foreach ($supplier as $s)
                            <option value="{{ $s->id_supplier }}" @selected($item->id_supplier === $s->id_supplier)>
                                {{ $s->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-base">Harga :</label>
                    <input type="number" name="harga" value="{{ (int) $item->harga }}" min="0" required
                        class="w-full border rounded-xl px-4 py-2">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-base">Stok :</label>
                        <input type="number" name="stok" value="{{ $item->stok }}" min="0" required
                            class="w-full border rounded-xl px-4 py-2">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-base">Satuan :</label>
                        <select name="satuan" required class="w-full border rounded-xl px-4 py-2">
                            @foreach (['pcs', 'unit', 'karton'] as $sat)
                                <option value="{{ $sat }}" @selected($item->satuan === $sat)>{{ ucfirst($sat) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-base">Lokasi Rak :</label>
                    <input type="text" name="lokasi_rak" value="{{ $item->lokasi_rak }}" maxlength="50"
                        class="w-full border rounded-xl px-4 py-2">
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-base">Deskripsi :</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full border rounded-xl px-4 py-2">{{ $item->deskripsi }}</textarea>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-base">Gambar :</label>
                    @if ($item->path_gambar)
                        <img src="{{ asset('storage/' . $item->path_gambar) }}" class="w-16 h-16 object-cover rounded">
                    @endif
                    <input type="file" name="gambar" accept="image/png,image/jpeg,image/webp"
                        class="w-full border rounded-xl px-4 py-2 file:mr-3 file:rounded-lg file:border-0 file:bg-gray-800 file:px-3 file:py-1 file:text-white">
                    <span class="text-xs text-gray-500">Kosongkan kalau tidak ingin mengganti gambar.</span>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" data-close-modal="editBarangModal{{ $item->id_produk }}"
                        class="px-4 cursor-pointer py-2 border rounded-lg">Batal</button>
                    <button type="submit"
                        class="px-6 cursor-pointer py-2 bg-gray-800 hover:bg-gray-600 text-white rounded-lg">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endforeach