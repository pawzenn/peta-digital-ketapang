<!doctype html>
<html lang="id" class="page-fade">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin - Peta Digital Ketapang')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-neutral-50 text-neutral-900">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="flex w-72 shrink-0 flex-col border-r border-neutral-200 bg-white">
        <div class="flex items-center gap-3 px-6 py-5 border-b border-neutral-200">
            <img src="{{ asset('images/logo-ketapang.png') }}" alt="Logo Desa Ketapang" class="h-9 w-auto">
            <div>
                <div class="text-xs text-neutral-400">Admin Panel</div>
                <div class="font-serif font-bold text-emerald-900">Desa Ketapang</div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1 text-sm">
            @php
                $icons = [
                    'dashboard' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />',
                    'profil' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.804a1.125 1.125 0 00-1.006 0L3.622 6.24C3.24 6.43 3 6.822 3 7.247v11.006c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z" />',
                    'wisata' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />',
                    'homestay' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />',
                    'umkm' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.09-2.577 2.25-6.75H5.106M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />',
                    'kategori' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />',
                    'bencana' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />',
                ];

                $navItem = function (string $active, string $route, string $label, string $icon) {
                    $isActive = request()->routeIs($active);
                    $classes = 'group relative flex items-center gap-3 rounded-lg px-3 py-2.5 transition-colors '
                        . ($isActive ? 'bg-emerald-50 font-semibold text-emerald-900' : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900');
                    $bar = $isActive ? '<span class="absolute left-0 top-1/2 h-5 w-1 -translate-y-1/2 rounded-r bg-emerald-700"></span>' : '';
                    $iconColor = $isActive ? 'text-emerald-700' : 'text-neutral-400 group-hover:text-neutral-500';

                    return '<a href="'.route($route).'" class="'.$classes.'">'
                        . $bar
                        . '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" class="h-5 w-5 shrink-0 '.$iconColor.'">'.$icon.'</svg>'
                        . '<span>'.$label.'</span>'
                        . '</a>';
                };
            @endphp

            {!! $navItem('admin.dashboard', 'admin.dashboard', 'Dashboard', $icons['dashboard']) !!}

            <div class="pt-5 pb-2 px-3 text-xs font-semibold uppercase tracking-wide text-neutral-400">
                Konten
            </div>

            {!! $navItem('admin.profil.*', 'admin.profil.edit', 'Profil Desa', $icons['profil']) !!}
            {!! $navItem('admin.wisata.*', 'admin.wisata.index', 'Wisata', $icons['wisata']) !!}
            {!! $navItem('admin.homestay.*', 'admin.homestay.index', 'Homestay', $icons['homestay']) !!}
            {!! $navItem('admin.umkm.*', 'admin.umkm.index', 'UMKM', $icons['umkm']) !!}
            {!! $navItem('admin.kategori-umkm.*', 'admin.kategori-umkm.index', 'Kategori UMKM', $icons['kategori']) !!}
            {!! $navItem('admin.bencana.*', 'admin.bencana.index', 'Bencana', $icons['bencana']) !!}
        </nav>

        <div class="border-t border-neutral-200 px-6 py-4 text-xs text-neutral-400">
            Peta Digital Ketapang &copy; {{ date('Y') }}
        </div>
    </aside>

    <!-- MAIN -->
    <div class="flex flex-1 flex-col">

        <!-- TOPBAR -->
        <header class="sticky top-0 z-10 border-b border-neutral-200 bg-white/90 backdrop-blur">
            <div class="flex items-center justify-between px-8 py-4">
                <div>
                    <h1 class="text-lg font-semibold text-neutral-900">@yield('page_title', 'Dashboard')</h1>
                    @hasSection('page_subtitle')
                        <p class="mt-0.5 text-sm text-neutral-500">@yield('page_subtitle')</p>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <a href="/" target="_blank" class="inline-flex items-center gap-1.5 rounded-lg border border-neutral-300 px-3 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                        Lihat Website
                    </a>

                    @auth
                        <div class="flex items-center gap-3 border-l border-neutral-200 pl-4">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-800 text-sm font-semibold text-white">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="hidden sm:block">
                                <div class="text-sm font-medium leading-tight text-neutral-900">{{ auth()->user()->name ?? 'Admin' }}</div>
                                <div class="text-xs leading-tight text-neutral-400">Administrator</div>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" title="Logout" class="inline-flex items-center justify-center rounded-lg border border-neutral-200 p-2 text-neutral-500 transition-colors hover:bg-red-50 hover:text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="flex-1 p-8">
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
