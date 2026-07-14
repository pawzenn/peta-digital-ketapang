<!doctype html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Peta Digital Desa Ketapang')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php $isHome = request()->is('/'); @endphp

<body class="flex min-h-screen flex-col bg-[#FFFCF2] text-neutral-900">

    <!-- HEADER -->
    <header class="relative z-20 h-20 border-b {{ $isHome ? 'border-white/30' : 'border-black/5 bg-[#FFFCF2]' }}">
        <div class="mx-auto flex h-full max-w-7xl items-center justify-between px-6">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-ketapang.png') }}" alt="Logo Desa Ketapang" class="h-10 w-auto">
                <span class="font-serif text-lg font-bold text-emerald-900">Desa Ketapang</span>
            </a>

            @php
                $navLinks = [
                    '/' => 'Home',
                    '/profil' => 'Profil',
                    '/wisata' => 'Wisata',
                    '/umkm' => 'UMKM',
                    '/homestay' => 'Homestay',
                    '/#peta-bencana' => 'Bencana',
                ];
            @endphp

            <nav class="flex gap-7 text-sm font-medium text-neutral-700">
                @foreach($navLinks as $url => $label)
                    @php
                        $isActive = $url === '/' ? request()->is('/') : request()->is(ltrim($url, '/').'*');
                    @endphp
                    <a href="{{ $url }}"
                       class="transition-colors hover:text-emerald-800 {{ $isActive ? 'font-semibold text-emerald-900' : '' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-black/5 bg-[#FFFCF2]">
        <div class="mx-auto max-w-7xl px-6 py-6 text-sm text-neutral-500">
            © {{ date('Y') }} Desa Ketapang
        </div>
    </footer>

</body>
</html>
