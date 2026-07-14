<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin - Peta Digital Ketapang')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">

<div class="min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-white border-r">
        <div class="px-6 py-5 border-b">
            <div class="text-sm text-gray-500">Admin Panel</div>
            <div class="font-bold text-lg">Peta Digital Ketapang</div>
        </div>

        <nav class="p-4 space-y-1 text-sm">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-3 py-2 rounded hover:bg-gray-100
                      {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 font-semibold' : '' }}">
                Dashboard
            </a>

            <div class="pt-4 pb-2 px-3 text-xs font-semibold text-gray-500 uppercase">
                Konten
            </div>

            {{-- Profil Desa (route belum dibuat, sementara ke dashboard) --}}
            <a href="{{ route('admin.profil.edit') }}"
               class="flex items-center px-3 py-2 rounded hover:bg-gray-100
                      {{ request()->routeIs('admin.profile.*') ? 'bg-gray-100 font-semibold' : '' }}">
                Profil Desa
            </a>

            {{-- ✅ Wisata (route sudah ada) --}}
            <a href="{{ route('admin.wisata.index') }}"
               class="flex items-center px-3 py-2 rounded hover:bg-gray-100
                      {{ request()->routeIs('admin.wisata.*') ? 'bg-gray-100 font-semibold' : '' }}">
                Wisata
            </a>

         
            <a href="{{ route('admin.homestay.index') }}"
               class="flex items-center px-3 py-2 rounded hover:bg-gray-100
                      {{ request()->routeIs('admin.homestay.*') ? 'bg-gray-100 font-semibold' : '' }}">
                Homestay
            </a>

           
            <a href="{{ route('admin.umkm.index') }}"
               class="flex items-center px-3 py-2 rounded hover:bg-gray-100
                      {{ request()->routeIs('admin.umkm.*') ? 'bg-gray-100 font-semibold' : '' }}">
                UMKM
            </a>

           
            <a href="{{ route('admin.kategori-umkm.index') }}"
               class="flex items-center px-3 py-2 rounded hover:bg-gray-100
                      {{ request()->routeIs('admin.kategori-umkm.*') ? 'bg-gray-100 font-semibold' : '' }}">
                Kategori UMKM
            </a>

            <a href="{{ route('admin.bencana.index') }}"
               class="flex items-center px-3 py-2 rounded hover:bg-gray-100
                      {{ request()->routeIs('admin.bencana.*') ? 'bg-gray-100 font-semibold' : '' }}">
                Bencana
            </a>
        </nav>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white border-b">
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold">@yield('page_title', 'Dashboard')</h1>
                    @hasSection('page_subtitle')
                        <p class="text-sm text-gray-500 mt-1">@yield('page_subtitle')</p>
                    @endif
                </div>

                <div class="flex items-center gap-3">
                    <a href="/" target="_blank" class="text-sm px-3 py-2 rounded border hover:bg-gray-50">
                        Lihat Website
                    </a>

                    @auth
                        <div class="text-sm text-gray-600">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm px-3 py-2 rounded bg-black text-white hover:bg-gray-800">
                                Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="p-6">
            @if (session('status'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 rounded border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
