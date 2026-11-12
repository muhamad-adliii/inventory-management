@foreach ($supplier as $item)
    <div id="hapusBarangModal" class="hidden fixed inset-0 bg-black/40 z-20 items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6">
            <!-- header -->
            <div class="flex justify-between items-center mb-10">
                <h2 class="font-medium text-lg md:text-xl">Hapus Supplier</h2>
                <button data-close-modal="hapusBarangModal" class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- button -->
            <p class="text-center text-lg font-normal">Apakah Anda yakin ingin menghapus Supplier ini?</p>
            <div class="flex justify-center gap-3 pt-7">
                <form action="{{ route('supplier.destroy', $item->id_supplier) }}" method="POST"
                    class="flex justify-end gap-2 mt-6">
                    @csrf
                    @method('DELETE')
                    <button type="button" data-modal-close
                        class="px-4 py-2 rounded-lg border border-gray-300 cursor-pointer">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white cursor-pointer">Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endforeach