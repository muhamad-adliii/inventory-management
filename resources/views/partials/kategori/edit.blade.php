@foreach ($kategori as $item)
    <div id="editBarangModal{{ $item->id_kategori }}"
        class="hidden fixed inset-0 bg-black/40 z-20 items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6">
            <div class="flex justify-between items-center mb-12">
                <h2 class="font-medium text-lg md:text-xl">Edit Kategori</h2>
                <button type="button" data-close-modal="editBarangModal{{ $item->id_kategori }}" class="cursor-pointer">
                    {{-- svg X --}}
                </button>
            </div>

            <form action="{{ route('kategori.update', $item->id_kategori) }}" method="post" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="flex flex-col gap-2">
                    <label for="nama_kategori_{{ $item->id_kategori }}" class="text-base">Nama Kategori :</label>
                    <input type="text" id="nama_kategori_{{ $item->id_kategori }}" name="nama_kategori"
                        value="{{ $item->nama_kategori }}" required class="p-2 border-2 border-gray-300 rounded-lg">
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" data-close-modal="editBarangModal{{ $item->id_kategori }}"
                        class="px-4 cursor-pointer py-2 border rounded-lg">Batal</button>
                    <button type="submit"
                        class="px-4 cursor-pointer py-2 bg-gray-800 hover:bg-gray-600 text-white rounded-lg">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endforeach