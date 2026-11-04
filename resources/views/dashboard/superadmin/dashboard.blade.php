@extends('layouts.app-superadmin')

@section('content')
    <div class="p-4 md:p-6 bg-[#ffffff] rounded-xl">
        <div class="text-header text-xl md:text-2xl uppercase font-medium">
            <h3>Super Admin dashboard</h3>
        </div>

        <!-- Card Grid -->
        <div class="card-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mt-5">
            <div class="card flex items-center p-4 md:p-5 bg-[#e4f5ff] justify-between rounded-lg">
                <div class="capitalize space-y-2 md:space-y-4">
                    <h3 class="text-gray-600 font-medium text-sm md:text-base">total barang</h3>
                    <p class="font-bold text-2xl md:text-3xl">1.00K</p>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8 md:size-10 text-[#64ccff]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 0 1 1.872 1.002l.164.246a2.25 2.25 0 0 0 1.872 1.002h2.092a2.25 2.25 0 0 0 1.872-1.002l.164-.246A2.25 2.25 0 0 1 16.954 9h4.636M2.41 9a2.25 2.25 0 0 0-.16.832V12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 0 1 .382-.632l3.285-3.832a2.25 2.25 0 0 1 1.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
            </div>
            <div class="card flex items-center p-4 md:p-5 bg-[#f1e7ff] justify-between rounded-lg">
                <div class="capitalize space-y-2 md:space-y-4">
                    <h3 class="text-gray-600 font-medium text-sm md:text-base">stok</h3>
                    <p class="font-bold text-2xl md:text-3xl">400</p>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8 md:size-10 text-[#af7bf4]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>
                </div>
            </div>
            <div class="card flex items-center p-4 md:p-5 bg-[#ffefe7] justify-between rounded-lg">
                <div class="capitalize space-y-2 md:space-y-4">
                    <h3 class="text-gray-600 font-medium text-sm md:text-base">penjualan hari ini</h3>
                    <p class="font-bold text-2xl md:text-3xl">500</p>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8 md:size-10 text-[#ff9866]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </div>
            </div>
            <div class="card flex items-center p-4 md:p-5 bg-[#ebfdef] justify-between rounded-lg">
                <div class="capitalize space-y-2 md:space-y-4">
                    <h3 class="text-gray-600 font-medium text-sm md:text-base">pendapatan</h3>
                    <p class="font-bold text-2xl md:text-3xl">2.000.000</p>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8 md:size-10 text-[#5cca76]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 mb-16">
        <div class="bg-white rounded-xl shadow p-4 md:p-6">
            <h2 class="font-medium mb-4 capitalize text-lg md:text-xl">data penjualan</h2>
            <div class="chart-container" style="height: 300px; width: 100%; position: relative;">
                <canvas id="myChart" style="width: 100%; height: 100%;"></canvas>
            </div>
        </div>
    </div>
@endsection