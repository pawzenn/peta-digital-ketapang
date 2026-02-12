<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Peta Digital Desa Ketapang')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-gray-50 text-gray-900">

    <!-- HEADER -->
    <header class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="font-bold text-lg">
                Peta Digital Ketapang
            </a>

            <nav class="flex gap-6 text-sm font-medium">
                <a href="/profil" class="hover:text-blue-600">Profil</a>
                <a href="/wisata" class="hover:text-blue-600">Wisata</a>
                <a href="/homestay" class="hover:text-blue-600">Homestay</a>
                <a href="/umkm" class="hover:text-blue-600">UMKM</a>
                <a href="/bencana" class="hover:text-blue-600">Bencana</a>
            </nav>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-6 py-6 text-sm text-gray-500">
            © {{ date('Y') }} Desa Ketapang
        </div>
    </footer>

</body>
</html>
