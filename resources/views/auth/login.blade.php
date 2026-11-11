@extends('layouts.auth')

@section('content')
    <div class="wrapper p-7 flex flex-col rounded-2xl bg-[#ffffff] w-125 capitalize shadow-xl">
        <div class="flex flex-col justify-center items-center mb-10 mt-8 gap-2">
            <div class="p-3 bg-blue-200 rounded-4xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8 text-blue-900">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                </svg>
            </div>
            <span class="capitalize text-3xl font-bold">login</span>
        </div>

        <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-3">
            @csrf

            @if ($errors->any())
                <div class="p-3 mb-2 rounded-lg bg-red-100 text-red-700 text-sm normal-case">
                    {{ $errors->first() }}
                </div>
            @endif

            <label for="username" class="text-base font-semibold">username</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" placeholder="admin" required
                autofocus class="p-2 border-2 border-gray-400 mb-4 rounded-lg normal-case">

            <label for="password" class="text-base font-semibold">password</label>
            <input type="password" name="password" id="password" placeholder="Password" required
                class="p-2 border-2 border-gray-400 mb-4 rounded-lg normal-case">

            <button type="submit"
                class="cursor-pointer capitalize bg-[#3345df] py-3 rounded-xl text-lg text-[#ffffff] hover:bg-[#142088] mb-5">
                log in
            </button>
        </form>
    </div>
@endsection