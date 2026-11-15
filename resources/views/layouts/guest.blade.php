<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/toon-head.png') }}">

        <title>{{ config('app.name', 'Toon Burger') }}</title>

        <!-- Google Fonts: BBH Hegarty, Luckiest Guy & Poppins -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=BBH+Hegarty&family=Luckiest+Guy&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">

        <!-- Vite Assets -->
        @vite(['resources/css/app.css'])
    </head>
    <body class="min-h-full bg-[#F1D9B3] text-gray-900 antialiased flex flex-col justify-center items-center py-10 px-4 sm:px-6">
        <div class="w-full sm:max-w-md flex flex-col items-center">
            <div class="mb-6 p-3 bg-[#466967] rounded-2xl shadow-md">
                <a href="{{ route('home') }}" class="focus:outline-none focus:ring-2 focus:ring-white rounded-lg block">
                    <x-application-logo class="w-28 h-auto" />
                </a>
            </div>

            <div class="w-full bg-white shadow-xl rounded-3xl p-6 sm:p-8 border border-gray-100">
                {{ $slot }}
            </div>

            <div class="mt-6 text-center text-xs text-[#466967] font-semibold">
                <a href="{{ route('login') }}" class="hover:underline focus:outline-none focus:ring-2 focus:ring-[#466967] rounded px-2 py-1">
                    &larr; Kembali ke Halaman Login
                </a>
            </div>
        </div>
    </body>
</html>
