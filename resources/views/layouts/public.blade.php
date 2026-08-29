<!doctype html>
<html lang="id" class="scroll-smooth page-fade">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Peta Digital Desa Ketapang')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $isHome = request()->is('/');
    $isDarkDetail = request()->is('wisata/*') || request()->is('homestay/*') || request()->is('umkm/*');
@endphp

<body class="flex min-h-screen flex-col {{ $isDarkDetail ? 'bg-neutral-950 text-white' : 'bg-[#FFFCF2] text-neutral-900' }}">

    @unless($isDarkDetail)
        {{-- full-page decorative background: fixed to the viewport so it stays put while the page
             scrolls. Sits behind everything (z-0) and is covered by the hero's own photo; only
             becomes visible once the hero scrolls out of view. Purely visual, so pointer-events
             are disabled. --}}
        <div
            class="pointer-events-none fixed inset-0 z-0 bg-cover bg-center opacity-[0.04]"
            style="background-image:url('{{ asset('images/background-full.svg') }}');"
            aria-hidden="true"
        ></div>
    @endunless

    <!-- HEADER -->
    <header
        x-data="{
            mobileOpen: false,
            isHome: {{ $isHome ? 'true' : 'false' }},
            isDarkDetail: {{ $isDarkDetail ? 'true' : 'false' }},
            scrolled: false,
            dark() { return (this.isHome && !this.scrolled) || this.isDarkDetail }
        }"
        x-init="scrolled = window.scrollY > 40"
        @scroll.window="scrolled = window.scrollY > 40"
        @keydown.escape.window="mobileOpen = false"
        @click.outside="mobileOpen = false"
        :class="dark() ? 'border-white/20 bg-white/20' : 'border-black/5 bg-[#FFFCF2]/95 backdrop-blur-md shadow-sm'"
        class="sticky top-0 z-20 h-20 border-b transition-colors duration-300"
    >
        <div class="mx-auto flex h-full max-w-7xl items-center justify-between px-6">
            <a href="/" class="flex shrink-0 items-center gap-3">
                <img src="{{ asset('images/logo-ketapang.png') }}" alt="Logo Desa Ketapang" class="h-9 w-auto md:h-10">
                <span class="whitespace-nowrap font-serif text-base font-bold md:text-lg"
                      :class="dark() ? 'text-white' : 'text-emerald-900'">Desa Ketapang</span>
            </a>

            @php
                $navLinks = [
                    '/' => 'Home',
                    '/profil' => 'Profil',
                    '/wisata' => 'Wisata',
                    '/umkm' => 'UMKM',
                    '/homestay' => 'Homestay',
                    '/bencana' => 'Bencana',
                ];
            @endphp

            <nav class="hidden gap-7 text-sm font-medium md:flex" :class="dark() ? 'text-white/90' : 'text-neutral-700'">
                @foreach($navLinks as $url => $label)
                    @php
                        $isActive = $url === '/' ? request()->is('/') : request()->is(ltrim($url, '/').'*');
                    @endphp
                    <a href="{{ $url }}"
                       :class="dark() ? 'hover:text-white{{ $isActive ? ' font-semibold text-white' : '' }}' : 'hover:text-emerald-800{{ $isActive ? ' font-semibold text-emerald-900' : '' }}'"
                       class="transition-colors">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>

            <button
                @click="mobileOpen = !mobileOpen"
                type="button"
                aria-label="Buka menu"
                :class="dark() ? 'text-white hover:bg-white/10' : 'text-neutral-700 hover:bg-black/5'"
                class="inline-flex items-center justify-center rounded-lg p-2 transition-colors md:hidden"
            >
                <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                </svg>
                <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- MOBILE MENU -->
        <div
            x-show="mobileOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            :class="dark() ? 'border-t border-white/20 bg-black/20' : 'border-t border-black/10 bg-white/60'"
            class="absolute inset-x-0 top-full z-30 shadow-lg backdrop-blur-md md:hidden"
        >
            <nav class="mx-auto flex max-w-7xl flex-col gap-1 px-6 py-4 text-sm font-medium"
                 :class="dark() ? 'text-white/90' : 'text-neutral-700'">
                @foreach($navLinks as $url => $label)
                    @php
                        $isActive = $url === '/' ? request()->is('/') : request()->is(ltrim($url, '/').'*');
                    @endphp
                    <a href="{{ $url }}"
                       @click="mobileOpen = false"
                       :class="dark() ? 'hover:bg-white/10 hover:text-white{{ $isActive ? ' bg-white/15 font-semibold text-white' : '' }}' : 'hover:bg-emerald-50 hover:text-emerald-800{{ $isActive ? ' bg-emerald-50 font-semibold text-emerald-900' : '' }}'"
                       class="rounded-lg px-3 py-2.5 transition-colors">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="relative z-10 flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="relative z-10 border-t border-black/5 bg-[#FFFCF2]">
        <div class="mx-auto max-w-7xl px-6 py-10">

            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo-ketapang.png') }}" alt="Logo Desa Ketapang" class="h-7 w-auto">
                <span class="font-serif text-base font-bold text-emerald-900">Desa Ketapang</span>
            </div>

            @php
                $footerLinks = [];

                if ($footerProfil?->email) {
                    $footerLinks['email'] = [
                        'href' => 'mailto:' . $footerProfil->email,
                        'label' => $footerProfil->email,
                        'external' => false,
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />',
                    ];
                }

                if ($footerProfil?->whatsapp) {
                    $footerLinks['whatsapp'] = [
                        'href' => 'https://wa.me/' . $footerProfil->whatsapp,
                        'label' => $footerProfil->whatsapp,
                        'external' => true,
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a1.5 1.5 0 001.5-1.5v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5a1.5 1.5 0 00-1.5 1.5v2.25z" />',
                    ];
                }
            @endphp

            <div class="mt-4 flex flex-col gap-x-6 gap-y-2 text-sm text-neutral-500 sm:flex-row sm:flex-wrap sm:items-center">
                @if($footerProfil?->alamat)
                    <div class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" class="mt-0.5 h-4 w-4 shrink-0 text-neutral-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        <span>{{ $footerProfil->alamat }}</span>
                    </div>
                @endif

                @foreach($footerLinks as $link)
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" class="h-4 w-4 shrink-0 text-neutral-400">
                            {!! $link['icon'] !!}
                        </svg>
                        <a href="{{ $link['href'] }}" @if($link['external']) target="_blank" rel="noopener" @endif class="transition-colors hover:text-emerald-800">{{ $link['label'] }}</a>
                    </div>
                @endforeach

                @php
                    $socials = [
                        'instagram' => ['label' => 'Instagram', 'icon' => '<path d="M12 0C8.74 0 8.333.014 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.014 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.014 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.014-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.014 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06zm0 3.678a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm7.846-10.405a1.44 1.44 0 11-2.881 0 1.44 1.44 0 012.881 0z"/>'],
                        'facebook' => ['label' => 'Facebook', 'icon' => '<path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.323-.593 1.323-1.325v-21.35C24 .593 23.407 0 22.675 0z"/>'],
                        'tiktok' => ['label' => 'TikTok', 'icon' => '<path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.58-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.43 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>'],
                        'youtube' => ['label' => 'YouTube', 'icon' => '<path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>'],
                    ];
                @endphp

                @foreach($socials as $key => $social)
                    @if($footerProfil?->{$key})
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 shrink-0 text-neutral-400">
                                {!! $social['icon'] !!}
                            </svg>
                            <a href="{{ $footerProfil->{$key} }}" target="_blank" rel="noopener" class="transition-colors hover:text-emerald-800">{{ $footerProfil->{$key.'_nama'} ?: $social['label'] }}</a>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="mt-8 border-t border-black/5 pt-6 text-sm text-neutral-500">
                <p>.</p>
                <p align="center"><a  target="_blank" rel="noopener">© {{ date('Y') }} Desa Ketapang X Universitas Muhammadiyah Malang</a></p>
            </div>
        </div>
    </footer>

</body>
</html>
