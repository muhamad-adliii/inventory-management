<div id="tambahBarangModal" class="hidden fixed inset-0 bg-black/40 z-20 items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto mt-20 mb-5">
        <!-- header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="font-medium text-lg md:text-xl">Tambah Produk</h2>
            <button type="button" data-close-modal="tambahBarangModal" class="cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- form -->
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="nama_produk" class="text-base">Nama Produk :</label>
                <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}" required
                    maxlength="100" class="w-full border rounded-xl px-4 py-2">
            </div>

            <div class="flex flex-col gap-2">
                <label for="id_kategori" class="text-base">Kategori :</label>
                <select id="id_kategori" name="id_kategori" required class="w-full border rounded-xl px-4 py-2">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori }}" @selected(old('id_kategori') === $k->id_kategori)>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-2">
                <label for="id_supplier" class="text-base">Supplier :</label>
                <select id="id_supplier" name="id_supplier" required class="w-full border rounded-xl px-4 py-2">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach ($supplier as $s)
                        <option value="{{ $s->id_supplier }}" @selected(old('id_supplier') === $s->id_supplier)>
                            {{ $s->nama_supplier }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-2">
                <label for="harga" class="text-base">Harga :</label>
                <input type="number" id="harga" name="harga" value="{{ old('harga') }}" min="0" required
                    class="w-full border rounded-xl px-4 py-2">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="stok" class="text-base">Stok :</label>
                    <input type="number" id="stok" name="stok" value="{{ old('stok', 0) }}" min="0" required
                        class="w-full border rounded-xl px-4 py-2">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="satuan" class="text-base">Satuan :</label>
                    <select id="satuan" name="satuan" required class="w-full border rounded-xl px-4 py-2">
                        @foreach (['pcs', 'unit', 'karton'] as $s)
                            <option value="{{ $s }}" @selected(old('satuan') === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label for="lokasi_rak" class="text-base">Lokasi Rak :</label>
                <input type="text" id="lokasi_rak" name="lokasi_rak" value="{{ old('lokasi_rak') }}" maxlength="50"
                    class="w-full border rounded-xl px-4 py-2">
            </div>

            <div class="flex flex-col gap-2">
                <label for="deskripsi" class="text-base">Deskripsi :</label>
                <textarea id="deskripsi" name="deskripsi" rows="3"
                    class="w-full border rounded-xl px-4 py-2">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex flex-col gap-2">
                <label for="gambar" class="text-base">Gambar :</label>
                <input type="file" id="gambar" name="gambar" accept="image/png,image/jpeg,image/webp"
                    class="w-full border rounded-xl px-4 py-2 file:mr-3 file:rounded-lg file:border-0 file:bg-gray-800 file:px-3 file:py-1 file:text-white">
                <span class="text-xs text-gray-500">Opsional. JPG, PNG, atau WEBP, maksimal 2 MB.</span>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" data-close-modal="tambahBarangModal"
                    class="px-4 cursor-pointer py-2 border rounded-lg">Batal</button>
                <button type="submit"
                    class="px-4 cursor-pointer py-2 bg-gray-800 hover:bg-gray-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>