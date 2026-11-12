@foreach ($supplier as $item)
    <div id="editBarangModal" class="hidden fixed inset-0 bg-black/40 z-20 items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg p-6">
            <!-- header -->
            <div class="flex justify-between items-center mb-12">
                <h2 class="font-medium text-lg md:text-xl">Edit Supplier</h2>
                <button data-close-modal="editBarangModal" class=" cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- form -->
            <form action="{{ route('supplier.update', $item->id_supplier) }}" method="POST" class="flex flex-col gap-3">
                @csrf
                @method('PUT')

                <label class="text-sm font-semibold">Nama Supplier</label>
                <input type="text" name="nama_supplier" value="{{ $item->nama_supplier }}" required maxlength="100"
                    class="p-2 border-2 border-gray-300 rounded-lg">

                <label class="text-sm font-semibold">Alamat</label>
                <input type="text" name="alamat" value="{{ $item->alamat }}" maxlength="255"
                    class="p-2 border-2 border-gray-300 rounded-lg">

                <label class="text-sm font-semibold">No HP</label>
                <input type="text" name="no_hp" value="{{ $item->no_hp }}" maxlength="20"
                    class="p-2 border-2 border-gray-300 rounded-lg">

                <label class="text-sm font-semibold">Email</label>
                <input type="email" name="email" value="{{ $item->email }}" maxlength="100"
                    class="p-2 border-2 border-gray-300 rounded-lg">

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" data-modal-close
                        class="px-4 py-2 rounded-lg border border-gray-300 cursor-pointer">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-[#5d5de7] hover:bg-[#4040e8] text-white cursor-pointer">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endforeach