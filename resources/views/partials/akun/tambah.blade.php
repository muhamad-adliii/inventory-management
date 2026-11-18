<div id="tambahAkunModal" role="dialog" aria-modal="true" aria-labelledby="tambahAkunTitle"
    class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center bg-gray-900/45 p-5">
    <div class="w-full max-w-md max-h-[90vh] overflow-y-auto rounded-2xl bg-white p-6">
        <h3 id="tambahAkunTitle" class="mb-5 text-xl font-medium capitalize">tambah akun</h3>

        <form method="POST" action="{{ route('akun.store') }}">
            @csrf

            <div class="mb-4">
                <label for="tambah_nama" class="mb-1.5 block text-sm text-gray-700">Nama</label>
                <input type="text" id="tambah_nama" name="nama" maxlength="100" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#345a94]">
            </div>

            <div class="mb-4">
                <label for="tambah_username" class="mb-1.5 block text-sm text-gray-700">Username</label>
                <input type="text" id="tambah_username" name="username" maxlength="50" required autocomplete="off"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#345a94]">
            </div>

            <div class="mb-4">
                <label for="tambah_password" class="mb-1.5 block text-sm text-gray-700">Password</label>
                <input type="password" id="tambah_password" name="password" minlength="8" required
                    autocomplete="new-password"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#345a94]">
                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter.</p>
            </div>

            <div class="mb-4">
                <label for="tambah_role" class="mb-1.5 block text-sm text-gray-700">Role</label>
                <select id="tambah_role" name="role" required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#345a94]">
                    <option value="admin">Admin</option>
                    <option value="superadmin">Super Admin</option>
                </select>
            </div>

            <div class="mt-2 flex justify-end gap-2.5">
                <button type="button" data-close-modal="tambahAkunModal"
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