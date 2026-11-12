@foreach ($kategori as $item)
    <div id="hapusBarangModal{{ $item->id_kategori }}"
        class="hidden fixed inset-0 bg-black/40 z-20 items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6">
            <!-- header -->
            <div class="flex justify-between items-center mb-10">
                <h2 class="font-medium text-lg md:text-xl">Hapus Kategori</h2>
                <button type="button" data-close-modal="hapusBarangModal{{ $item->id_kategori }}" class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <p class="text-center text-lg font-normal">
                Apakah Anda yakin ingin menghapus kategori <b>{{ $item->nama_kategori }}</b>?
            </p>

            <form action="{{ route('kategori.destroy', $item->id_kategori) }}" method="POST"
                class="flex justify-center gap-3 pt-7">
                @csrf
                @method('DELETE')
                <button type="button" data-close-modal="hapusBarangModal{{ $item->id_kategori }}"
                    class="px-4 cursor-pointer py-2 border rounded-lg">Batal</button>
                <button type="submit"
                    class="px-4 cursor-pointer py-2 bg-red-800 hover:bg-red-600 text-white rounded-lg">Hapus</button>
            </form>
        </div>
    </div>
@endforeach