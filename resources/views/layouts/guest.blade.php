<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="page-fade">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#FFFCF2] font-sans text-neutral-900 antialiased">
        <div class="flex min-h-screen flex-col items-center justify-center px-6 py-12">

            <a href="/" class="flex flex-col items-center gap-2">
                <img src="{{ asset('images/logo-ketapang.png') }}" alt="Logo Desa Ketapang" class="h-16 w-auto">
                <span class="font-serif text-xl font-bold text-emerald-900">Desa Ketapang</span>
            </a>

            <p class="mt-2 text-xs font-semibold uppercase tracking-[0.2em] text-orange-600">Admin Panel</p>

            <div class="mt-8 w-full sm:max-w-md overflow-hidden rounded-xl border border-black/5 bg-white px-6 py-8 shadow-sm">
                {{ $slot }}
            </div>

            <a href="/" class="mt-6 text-sm text-neutral-500 hover:text-emerald-800 hover:underline">
                &larr; Kembali ke situs
            </a>
        </div>
    </body>
</html>
