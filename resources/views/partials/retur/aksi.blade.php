<div id="modalKonfirmasi" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-sm p-6">
        <h4 id="modalJudul" class="text-lg font-medium text-gray-900"></h4>
        <p id="modalPesan" class="text-sm text-gray-600 mt-2"></p>

        <form id="formKonfirmasi" method="POST" class="flex justify-end gap-2 mt-6">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" id="modalStatus">
            <button type="button" id="btnBatal"
                class="px-4 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-50 cursor-pointer">
                Batal
            </button>
            <button type="submit" id="btnYa" class="px-4 py-2 text-sm rounded-md text-white cursor-pointer">
                Ya
            </button>
        </form>
    </div>
</div>