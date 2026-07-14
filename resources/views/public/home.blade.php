@extends('layouts.public')

@section('title', 'Beranda - Peta Digital Ketapang')

@section('content')

{{-- HERO --}}
<div class="relative -mt-20 flex h-screen items-center justify-center overflow-hidden">
    <img src="{{ asset('images/hero-ketapang.jpg') }}" alt="Pelabuhan Ketapang" class="absolute inset-0 h-full w-full object-cover">

    {{-- soft glow behind navbar, for legibility over the photo --}}
    <div class="pointer-events-none absolute inset-x-0 top-0 h-64 bg-[radial-gradient(ellipse_60%_100%_at_50%_0%,rgba(255,247,239,0.8),rgba(255,247,239,0)_70%)]"></div>

    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>

    <div class="relative mt-16 flex flex-col items-center px-6 text-center">
        <h1 class="font-serif text-4xl font-bold text-white md:text-5xl">
            Selamat Datang di Peta Digital Ketapang
        </h1>
        <p class="mt-4 max-w-xl text-white/85">
            Jelajahi wisata, homestay, dan UMKM Desa Ketapang, semua dalam satu peta digital.
        </p>

        <a href="#konten" class="mt-6 rounded-md bg-orange-500 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-orange-600">
            Yuk Jelajahi
        </a>
    </div>
</div>

<div id="konten" class="mx-auto max-w-7xl scroll-mt-20 px-6 py-16">

    {{-- PROFIL --}}
    <div class="grid gap-10 md:grid-cols-2 md:items-center">
        <div>
            <h2 class="text-2xl font-bold text-emerald-900">Profil Desa Ketapang</h2>
            <p class="mt-4 leading-relaxed text-neutral-600">
                {{ \Illuminate\Support\Str::limit($profil->deskripsi ?? 'Website informasi desa berbasis peta untuk wisata, homestay, UMKM, dan kebencanaan.', 480) }}
            </p>
        </div>

        @if(!empty($profil?->peta_wilayah))
            <img
                src="{{ asset('storage/' . $profil->peta_wilayah) }}"
                alt="Peta Wilayah"
                class="w-full rounded-xl border bg-white"
            >
        @endif
    </div>

    {{-- WISATA --}}
    <div class="mt-24">
        <x-public.section-header
            eyebrow="Jelajahi Alam"
            title="Wisata Desa Ketapang"
            subtitle="Pesona alam tersembunyi yang menanti untuk dijelajahi, dari tebing eksotis hingga aliran sungai yang menyejukkan."
            href="/wisata"
            align="left"
        />

        @if($wisataTop->count())
            @php
                $wisataItems = $wisataTop->map(fn ($w) => [
                    'nama' => $w->nama,
                    'deskripsi' => $w->deskripsi,
                    'coverUrl' => $w->cover_foto ? asset('storage/'.$w->cover_foto) : null,
                    'detailUrl' => '/wisata/'.$w->slug,
                    'rating' => $w->rating,
                ])->all();
            @endphp
            <div class="mt-6">
                <x-public.carousel :items="$wisataItems" />
            </div>
        @else
            <div class="mt-6 rounded-xl border bg-white p-6 text-neutral-500">Belum ada data wisata.</div>
        @endif
    </div>

    {{-- UMKM --}}
    <div class="mt-24">
        <x-public.section-header
            eyebrow="Produk Lokal"
            title="UMKM Desa Ketapang"
            subtitle="Karya dan cita rasa autentik hasil tangan warga, diracik dengan kehangatan khas pedesaan."
            href="/umkm"
            align="left"
        />

        @if($umkmTop->count())
            @php
                $umkmItems = $umkmTop->map(fn ($u) => [
                    'nama' => $u->nama,
                    'deskripsi' => $u->deskripsi,
                    'coverUrl' => $u->cover_foto ? asset('storage/'.$u->cover_foto) : null,
                    'detailUrl' => '/umkm/'.$u->slug,
                    'rating' => $u->rating,
                    'badge' => $u->kategori?->nama,
                ])->all();
            @endphp
            <div class="mt-6">
                <x-public.carousel :items="$umkmItems" />
            </div>
        @else
            <div class="mt-6 rounded-xl border bg-white p-6 text-neutral-500">Belum ada data UMKM.</div>
        @endif
    </div>

    {{-- HOMESTAY --}}
    <div class="mt-24">
        <x-public.section-header
            eyebrow="Tempat Menginap"
            title="Homestay Desa Ketapang"
            subtitle="Hunian nyaman bernuansa alam pedesaan untuk pengalaman menginap yang berkesan."
            href="/homestay"
            align="left"
        />

        @if($homestayTop->count())
            @php
                $homestayItems = $homestayTop->map(fn ($h) => [
                    'nama' => $h->nama,
                    'deskripsi' => $h->deskripsi,
                    'coverUrl' => $h->cover_foto ? asset('storage/'.$h->cover_foto) : null,
                    'detailUrl' => '/homestay/'.$h->slug,
                    'rating' => $h->rating,
                ])->all();
            @endphp
            <div class="mt-6">
                <x-public.carousel :items="$homestayItems" />
            </div>
        @else
            <div class="mt-6 rounded-xl border bg-white p-6 text-neutral-500">Belum ada data homestay.</div>
        @endif
    </div>

    {{-- PETA BENCANA --}}
    <div id="peta-bencana" class="mt-24 scroll-mt-24">
        <h2 class="text-2xl font-bold text-emerald-900">Peta Bencana</h2>

        @if(!empty($profil?->peta_bencana))
            <img
                src="{{ asset('storage/' . $profil->peta_bencana) }}"
                alt="Peta Bencana"
                class="mt-6 w-full rounded-xl border bg-white"
            >
        @else
            <div class="mt-6 rounded-xl border bg-white p-6 text-neutral-500">
                Peta bencana belum diunggah admin.
            </div>
        @endif
    </div>

</div>
@endsection
