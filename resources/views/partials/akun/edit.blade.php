{{-- Dipanggil di dalam @foreach dengan variabel $item --}}
<div id="editAkunModal{{ $item->id_akun }}" role="dialog" aria-modal="true"
    aria-labelledby="editAkunTitle{{ $item->id_akun }}"
    class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/45 p-5">
    <div class="w-full max-w-md max-h-[90vh] overflow-y-auto rounded-2xl bg-white p-6">
        <h3 id="editAkunTitle{{ $item->id_akun }}" class="mb-5 text-xl font-medium capitalize">edit akun</h3>

        <form method="POST" action="{{ route('akun.update', $item->id_akun) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="edit_nama_{{ $item->id_akun }}" class="mb-1.5 block text-sm text-gray-700">Nama</label>
                <input type="text" id="edit_nama_{{ $item->id_akun }}" name="nama" maxlength="100"
                    value="{{ $item->nama }}" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#345a94]">
            </div>

            <div class="mb-4">
                <label for="edit_username_{{ $item->id_akun }}"
                    class="mb-1.5 block text-sm text-gray-700">Username</label>
                <input type="text" id="edit_username_{{ $item->id_akun }}" name="username" maxlength="50"
                    value="{{ $item->username }}" required autocomplete="off"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#345a94]">
            </div>

            <!-- <div class="mb-4">
                <label for="edit_password_{{ $item->id_akun }}"
                    class="mb-1.5 block text-sm text-gray-700">Password</label>
                <input type="password" id="edit_password_{{ $item->id_akun }}" name="password" minlength="8"
                    autocomplete="new-password"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#345a94]">
                <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti password.</p>
            </div> -->

            <div class="mb-4">
                <label for="edit_role_{{ $item->id_akun }}" class="mb-1.5 block text-sm text-gray-700">Role</label>
                <select id="edit_role_{{ $item->id_akun }}" disabled
                    class="w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2.5 text-sm text-gray-500">
                    <option value="admin" @selected($item->role === 'admin')>Admin</option>
                    <option value="superadmin" @selected($item->role === 'superadmin')>Super Admin</option>
                </select>
                <p class="mt-1 text-xs text-gray-500">Role tidak bisa diubah setelah akun dibuat.</p>
            </div>

            <div class="mt-2 flex justify-end gap-2.5">
                <button type="button" data-close-modal="editAkunModal{{ $item->id_akun }}"
                    class="cursor-pointer rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-800 hover:bg-gray-200">
                    Batal
                </button>
                <button type="submit"
                    class="cursor-pointer rounded-lg bg-[#345a94] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#274570]">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>