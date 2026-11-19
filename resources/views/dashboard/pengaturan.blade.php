@extends(auth()->user()->role === 'admin' ? 'layouts.app-admin' : 'layouts.app-superadmin')

@section('content')
    @php
        $isSuperadmin = $akun->role === 'superadmin';
        $status = $isSuperadmin ? 'Kepala Gudang' : 'Karyawan';
        $inisial = strtoupper(mb_substr($akun->nama, 0, 1));
    @endphp

    <div class="p-6">
        <div class="mx-auto w-full max-w-full space-y-6">
            <div>
                <h1 class="text-2xl font-semibold ">Pengaturan</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola informasi akun dan keamanan login kamu.</p>
            </div>

            <section
                class="flex flex-col gap-5 rounded-xl border border-slate-200 bg-white p-6 sm:flex-row sm:items-center">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-slate-900 text-2xl font-semibold text-white"
                    aria-hidden="true">
                    {{ $inisial }}
                </div>

                <div class="min-w-0 flex-1">
                    <p class="truncate text-lg font-semibold text-slate-900">{{ $akun->nama }}</p>
                    <p class="truncate text-sm text-slate-500">&#64;{{ $akun->username }}</p>
                </div>

                <dl class="grid grid-cols-2 gap-x-8 gap-y-1 text-sm sm:text-right">
                    <div>
                        <dt class="text-slate-500">ID akun</dt>
                        <dd class="font-medium text-slate-900">{{ $akun->id_akun }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500">Status</dt>
                        <dd>
                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                                                                                {{ $isSuperadmin ? 'bg-amber-100 text-amber-800' : 'bg-sky-100 text-sky-800' }}">
                                {{ $status }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-xl border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="text-base font-semibold text-slate-900">Profil</h2>
                    <p class="mt-0.5 text-sm text-slate-500">Nama dan username dipakai untuk login dan tampil di riwayat
                        aktivitas.</p>
                </div>

                <form method="POST" action="{{ route('pengaturan.profil') }}" class="space-y-5 px-6 py-5">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="nama" class="mb-1.5 block text-sm font-medium text-slate-700">Nama lengkap</label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $akun->nama) }}" required
                                maxlength="100"
                                class="w-full rounded-lg border px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/20
                                                                                                {{ $errors->has('nama') ? 'border-red-400' : 'border-slate-300 focus:border-slate-900' }}">
                            @error('nama')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="username" class="mb-1.5 block text-sm font-medium text-slate-700">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username', $akun->username) }}"
                                required maxlength="50" autocomplete="username"
                                class="w-full rounded-lg border px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/20
                                                                                                {{ $errors->has('username') ? 'border-red-400' : 'border-slate-300 focus:border-slate-900' }}">
                            @error('username')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="status" class="mb-1.5 block text-sm font-medium text-slate-700">Status pekerjaan</label>
                        <input type="text" id="status" value="{{ $status }}" disabled
                            class="w-full cursor-not-allowed rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-500 sm:max-w-xs">
                    </div>

                    <div class="flex justify-end border-t border-slate-100 pt-4 ">
                        <button type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 cursor-pointer">
                            Simpan profil
                        </button>
                    </div>
                </form>
            </section>

            <section class="rounded-xl border border-slate-200 bg-white">
                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="text-base font-semibold text-slate-900">Ubah password</h2>
                    <p class="mt-0.5 text-sm text-slate-500">Gunakan minimal 8 karakter.</p>
                </div>

                <form method="POST" action="{{ route('pengaturan.password') }}" class="space-y-5 px-6 py-5">
                    @csrf
                    @method('PUT')

                    <div class="sm:max-w-sm">
                        <label for="password_lama" class="mb-1.5 block text-sm font-medium text-slate-700">Password saat
                            ini</label>
                        <input type="password" id="password_lama" name="password_lama" required
                            autocomplete="current-password"
                            class="w-full rounded-lg border px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/20
                                                                                            {{ $errors->has('password_lama') ? 'border-red-400' : 'border-slate-300 focus:border-slate-900' }}">
                        @error('password_lama')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password
                                baru</label>
                            <input type="password" id="password" name="password" required minlength="8"
                                autocomplete="new-password"
                                class="w-full rounded-lg border px-3 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/20
                                                                                                {{ $errors->has('password') ? 'border-red-400' : 'border-slate-300 focus:border-slate-900' }}">
                            @error('password')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="mb-1.5 block text-sm font-medium text-slate-700">Ulangi
                                password baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                minlength="8" autocomplete="new-password"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/20">
                        </div>
                    </div>

                    <div class="flex justify-end border-t border-slate-100 pt-4 ">
                        <button type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2 cursor-pointer">
                            Ubah password
                        </button>
                    </div>
                </form>
            </section>

        </div>
    </div>
@endsection