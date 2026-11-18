@extends('layouts.app-superadmin')

@section('content')
    <div class="wrapper-barang p-6">
        <h3 class="text-header text-xl md:text-2xl uppercase font-medium">management akun</h3>
        @if (session('success'))
            <div class="mt-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mt-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mt-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mt-5">
            <div class="card flex flex-col p-4 md:p-5 bg-[#ffffff] justify-between rounded-lg border-1 border-gray-300">
                <div class="flex justify-between capitalize space-y-2 md:space-y-4">
                    <div class="p-3 bg-[#345a94] rounded-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-8 md:size-10 text-[#ffffff]">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <div class="p-2 h-2 rounded-2xl bg-[#345a94]"></div>
                </div>
                <div class="mt-5">
                    <p class="font-bold text-xl md:text-2xl">{{ $totalUsers }}</p>
                    <h3 class="text-gray-600 font-medium text-sm md:text-base capitalize">total users</h3>
                </div>
            </div>

            <div class="card flex flex-col p-4 md:p-5 bg-[#ffffff] justify-between rounded-lg border-1 border-gray-300">
                <div class="flex justify-between capitalize space-y-2 md:space-y-4">
                    <div class="p-3 bg-[#345a94] rounded-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-8 md:size-10 text-[#ffffff]">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                        </svg>
                    </div>
                    <div class="p-2 h-2 rounded-2xl bg-[#c8d5de]"></div>
                </div>
                <div class="mt-5">
                    <p class="font-bold text-xl md:text-2xl">{{ $totalSuperadmin }}</p>
                    <h3 class="text-gray-600 font-medium text-sm md:text-base capitalize">super admin</h3>
                </div>
            </div>

            <div class="card flex flex-col p-4 md:p-5 bg-[#ffffff] justify-between rounded-lg border-1 border-gray-300">
                <div class="flex justify-between capitalize space-y-2 md:space-y-4">
                    <div class="p-3 bg-[#345a94] rounded-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-8 md:size-10 text-[#ffffff]">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                    <div class="p-2 h-2 rounded-2xl bg-[#c8d5de]"></div>
                </div>
                <div class="mt-5">
                    <p class="font-bold text-xl md:text-2xl">{{ $totalAdmin }}</p>
                    <h3 class="text-gray-600 font-medium text-sm md:text-base capitalize">admin</h3>
                </div>
            </div>
            <div data-modal-target="tambahAkunModal"
                class="card flex flex-col p-4 md:p-5 bg-[#e4ebf5] justify-between rounded-lg border-1 border-gray-300 cursor-pointer hover:bg-[#d8e2f0] transition">
                <div class="flex justify-between capitalize space-y-2 md:space-y-4">
                    <div class="p-3 bg-[#c3d3de] rounded-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-8 md:size-10 text-[#ffffff]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                </div>
                <div class="mt-5">
                    <h3 class="text-gray-600 font-medium text-sm md:text-base capitalize">tambah akun</h3>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <form method="GET" action="{{ route('akun.index') }}"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-[2fr_2.2fr_1.2fr_1.4fr_5rem] gap-3 lg:gap-4 px-0 lg:px-2">
                <div class="flex flex-col gap-1">
                    <label for="filter-name" class="text-xs font-medium text-gray-500 capitalize">nama</label>
                    <input type="text" name="name" id="filter-name" value="{{ request('name') }}"
                        class="w-full px-3 py-3 text-xs bg-white rounded-xl outline-none shadow-sm border border-gray-300 focus:border-[#345a94]">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="filter-username" class="text-xs font-medium text-gray-500 capitalize">username</label>
                    <input type="text" name="username" id="filter-username" value="{{ request('username') }}"
                        class="w-full px-3 py-3 text-xs bg-white rounded-xl outline-none shadow-sm border border-gray-300 focus:border-[#345a94]">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="filter-role" class="text-xs font-medium text-gray-500 capitalize">role</label>
                    <select name="role" id="filter-role"
                        class="w-full px-3 py-3 text-xs bg-white rounded-xl outline-none shadow-sm border border-gray-300 focus:border-[#345a94]">
                        <option value="">All</option>
                        <option value="superadmin" @selected(request('role') === 'superadmin')>Super Admin</option>
                        <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="filter-sort" class="text-xs font-medium text-gray-500 capitalize">terakhir dibuat</label>
                    <select name="sort" id="filter-sort"
                        class="w-full px-3 py-3 text-xs bg-white rounded-xl outline-none shadow-sm border border-gray-300 focus:border-[#345a94]">
                        <option value="terbaru" @selected(request('sort') !== 'terlama')>Terbaru</option>
                        <option value="terlama" @selected(request('sort') === 'terlama')>Terlama</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1 sm:col-span-2 lg:col-span-1 justify-end">
                    <button type="submit"
                        class="cursor-pointer flex items-center justify-center gap-2 px-3 py-3 text-xs font-medium text-white bg-[#345a94] rounded-xl hover:bg-[#274570] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        Cari
                    </button>
                </div>
            </form>
            <div class="mt-4 bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">
                @if ($users->isEmpty())
                    <div class="flex flex-col items-center justify-center gap-3 py-16 px-6 text-center">
                        <div class="p-3 rounded-2xl bg-[#e4ebf5]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-8 text-[#345a94]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                        <p class="font-medium text-gray-700 capitalize">belum ada data akun</p>
                        <p class="text-sm text-gray-500">Akun yang ditambahkan akan tampil di sini.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-200 md:min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">NO</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nama</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Username</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($users as $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-semibold text-gray-900 sm:pl-6">
                                            {{ $users->firstItem() + $loop->index }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">{{ $item->nama }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $item->username }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            @if ($item->role === 'superadmin')
                                                <span class="inline-flex items-center rounded-full bg-[#e4ebf5] px-2.5 py-0.5 text-xs font-medium text-[#345a94]">Super Admin</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700">Admin</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            <div class="flex items-center gap-2">
                                                <button type="button" title="Edit" aria-label="Edit {{ $item->nama }}"
                                                    data-modal-target="editAkunModal{{ $item->id_akun }}"
                                                    class="cursor-pointer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                    </svg>
                                                </button>

                                                @if ($item->id_akun !== auth()->id())
                                                    <button type="button" title="Hapus" aria-label="Hapus {{ $item->nama }}"
                                                        data-modal-target="hapusAkunModal{{ $item->id_akun }}"
                                                        class="cursor-pointer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($users->hasPages())
                        <div class="border-t border-gray-100 px-5 py-3.5">
                            {{ $users->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    @include('partials.akun.tambah')

    @foreach ($users as $item)
        @include('partials.akun.edit', ['item' => $item])

        @if ($item->id_akun !== auth()->id())
            @include('partials.akun.hapus', ['item' => $item])
        @endif
    @endforeach
@endsection