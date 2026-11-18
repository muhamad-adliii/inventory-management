{{-- Dipanggil di dalam @foreach dengan variabel $item --}}
<div id="hapusAkunModal{{ $item->id_akun }}" role="dialog" aria-modal="true"
    aria-labelledby="hapusAkunTitle{{ $item->id_akun }}"
    class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/45 p-5">
    <div class="w-full max-w-sm rounded-2xl bg-white p-6">
        <h3 id="hapusAkunTitle{{ $item->id_akun }}" class="mb-3 text-xl font-medium">Hapus akun?</h3>
        <p class="mb-5 text-sm text-gray-600">
            Akun <strong class="text-gray-900">{{ $item->nama }}</strong> akan dihapus permanen.
        </p>

        <form method="POST" action="{{ route('akun.destroy', $item->id_akun) }}">
            @csrf
            @method('DELETE')

            <div class="flex justify-end gap-2.5">
                <button type="button" data-close-modal="hapusAkunModal{{ $item->id_akun }}"
                    class="cursor-pointer rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-800 hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit"
                    class="cursor-pointer rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-700">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>