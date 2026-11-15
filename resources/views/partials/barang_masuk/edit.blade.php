@foreach ($barangMasuk as $item)
    <div id="editBarangModal{{ $item->id_transaksi_masuk }}"
        class="hidden fixed inset-0 bg-black/40 z-20 items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6">
            <div class="flex justify-between items-center mb-8">
                <h2 class="font-medium text-lg md:text-xl">Edit Nota {{ $item->id_transaksi_masuk }}</h2>
                <button type="button" data-close-modal="editBarangModal{{ $item->id_transaksi_masuk }}"
                    class="cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('barang_masuk.update', $item->id_transaksi_masuk) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

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
                    <label class="text-base">No Invoice :</label>
                    <input type="text" name="no_invoice" value="{{ $item->no_invoice }}" maxlength="50"
                        class="w-full border rounded-xl px-4 py-2">
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" data-close-modal="editBarangModal{{ $item->id_transaksi_masuk }}"
                        class="px-4 cursor-pointer py-2 border rounded-lg">Batal</button>
                    <button type="submit"
                        class="px-6 cursor-pointer py-2 bg-gray-800 hover:bg-gray-600 text-white rounded-lg">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endforeach