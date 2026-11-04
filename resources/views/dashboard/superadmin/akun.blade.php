@extends('layouts.app-superadmin')

@section('content')
    <div class="wrapper-barang p-6">
        <h3 class="text-header text-xl md:text-2xl uppercase font-medium">management akun</h3>
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
                    <div class="p-2 h-2 rounded-2xl bg-[#345a94]">

                    </div>
                </div>
                <div class="mt-5">
                    <p class="font-bold text-xl md:text-2xl">50</p>
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
                    <div class="p-2 h-2 rounded-2xl bg-[#c8d5de]">
                    </div>
                </div>
                <div class="mt-5">
                    <p class="font-bold text-xl md:text-2xl">50</p>
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
                    <div class="p-2 h-2 rounded-2xl bg-[#c8d5de]">
                    </div>
                </div>
                <div class="mt-5">
                    <p class="font-bold text-xl md:text-2xl">50</p>
                    <h3 class="text-gray-600 font-medium text-sm md:text-base capitalize">admin</h3>
                </div>
            </div>
            <div
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
            <form method="GET"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-[2fr_2.2fr_1.2fr_1.4fr_5rem] gap-3 lg:gap-4 px-0 lg:px-2">
                <div class="flex flex-col gap-1">
                    <label for="filter-name" class="text-xs font-medium text-gray-500 capitalize">nama</label>
                    <input type="text" name="name" id="filter-name" value="{{ request('name') }}"
                        placeholder=""
                        class="w-full px-3 py-3 text-xs bg-white rounded-xl outline-none shadow-sm border border-transparent focus:border-[#345a94]">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="filter-email" class="text-xs font-medium text-gray-500 capitalize">e-mail</label>
                    <input type="text" name="email" id="filter-email" value="{{ request('email') }}"
                        placeholder=""
                        class="w-full px-3 py-3 text-xs bg-white rounded-xl outline-none shadow-sm border border-transparent focus:border-[#345a94]">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="filter-role" class="text-xs font-medium text-gray-500 capitalize">role</label>
                    <select name="role" id="filter-role"
                        class="w-full px-3 py-3 text-xs bg-white rounded-xl outline-none shadow-sm border border-transparent focus:border-[#345a94]">
                        <option value="">All</option>
                        <option value="superadmin" @selected(request('role') === 'superadmin')>Super Admin</option>
                        <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="filter-sort" class="text-xs font-medium text-gray-500 capitalize">terakhir dibuat</label>
                    <select name="sort" id="filter-sort"
                        class="w-full px-3 py-3 text-xs bg-white rounded-xl outline-none shadow-sm border border-transparent focus:border-[#345a94]">
                        <option value="terbaru" @selected(request('sort') === 'terbaru')>Terbaru</option>
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
            </div>

            <div class="flex items-center justify-center gap-2 mt-6">
                <span
                    class="flex items-center justify-center size-8 text-xs font-medium text-white bg-[#345a94] rounded-lg">1</span>
            </div>
        </div>
    </div>
@endsection