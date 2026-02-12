@extends('layouts.public')

@section('title', 'Beranda - Peta Digital Ketapang')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16">

    {{-- HERO / PROFIL --}}
    <h1 class="text-4xl font-bold">
        {{ $profil->nama ?? 'Peta Digital Desa Ketapang' }}
    </h1>

    <p class="mt-4 text-gray-600 max-w-2xl">
        {{ \Illuminate\Support\Str::limit($profil->deskripsi ?? 'Website informasi desa berbasis peta untuk wisata, homestay, UMKM, dan kebencanaan.', 150) }}
    </p>

    @if(!empty($profil?->peta_wilayah))
        <div class="mt-8">
            <img
                src="{{ asset('storage/' . $profil->peta_wilayah) }}"
                alt="Peta Wilayah"
                class="w-full max-w-3xl rounded border bg-white"
            >
            <div class="text-xs text-gray-500 mt-2">
                Peta wilayah desa (dikelola admin)
            </div>
        </div>
    @endif

    <div class="mt-8 flex gap-4">
        <a href="/wisata" class="px-5 py-3 bg-black text-white rounded">
            Jelajahi Wisata
        </a>
        <a href="/profil" class="px-5 py-3 border rounded">
            Profil Desa
        </a>
    </div>


    {{-- ============================= --}}
    {{-- SECTION WISATA (TOP 3 RATING) --}}
    {{-- ============================= --}}
    <div class="mt-20">

        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold">Wisata Terpopuler</h2>
            <a href="/wisata" class="text-sm underline text-gray-600">
                Lihat semua
            </a>
        </div>

        @if(isset($wisataTop) && $wisataTop->count())
            <div class="mt-6 grid md:grid-cols-3 gap-6">

                @foreach($wisataTop as $w)
                    <div class="bg-white rounded border overflow-hidden hover:shadow-md transition">

                        {{-- COVER --}}
                        <div class="bg-gray-100">
                            @if($w->cover_foto)
                                <img
                                    src="{{ asset('storage/' . $w->cover_foto) }}"
                                    alt="{{ $w->nama }}"
                                    class="w-full h-44 object-cover"
                                >
                            @else
                                <div class="w-full h-44 flex items-center justify-center text-gray-500">
                                    Tidak ada cover
                                </div>
                            @endif
                        </div>

                        {{-- CONTENT --}}
                        <div class="p-4">

                            <div class="text-xs text-gray-500">
                                Rating:
                                <span class="font-semibold">
                                    {{ $w->rating ?? '-' }}
                                </span>
                            </div>

                            <h3 class="mt-1 text-lg font-semibold">
                                {{ $w->nama }}
                            </h3>

                            <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                                {{ \Illuminate\Support\Str::limit($w->deskripsi ?? '', 110) }}
                            </p>

                            <div class="mt-4 flex gap-2">
                                <a href="/wisata/{{ $w->slug }}"
                                   class="px-3 py-2 rounded bg-black text-white text-sm">
                                    Detail
                                </a>

                                @if(!empty($w->maps_link))
                                    <a href="{{ $w->maps_link }}"
                                       target="_blank"
                                       class="px-3 py-2 rounded border text-sm">
                                        Maps
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        @else
            <div class="mt-6 p-6 bg-white rounded border text-gray-600">
                Belum ada data wisata.
            </div>
        @endif

    </div>

    {{-- ============================= --}}
{{-- SECTION HOMESTAY (TOP 3 RATING) --}}
{{-- ============================= --}}
<div class="mt-20">

    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold">Homestay Terpopuler</h2>
        <a href="/homestay" class="text-sm underline text-gray-600">
            Lihat semua
        </a>
    </div>

    @if(isset($homestayTop) && $homestayTop->count())
        <div class="mt-6 grid md:grid-cols-3 gap-6">

            @foreach($homestayTop as $h)
                <div class="bg-white rounded border overflow-hidden hover:shadow-md transition">

                    {{-- COVER --}}
                    <div class="bg-gray-100">
                        @if($h->cover_foto)
                            <img
                                src="{{ asset('storage/' . $h->cover_foto) }}"
                                alt="{{ $h->nama }}"
                                class="w-full h-44 object-cover"
                            >
                        @else
                            <div class="w-full h-44 flex items-center justify-center text-gray-500">
                                Tidak ada cover
                            </div>
                        @endif
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-4">

                        <div class="text-xs text-gray-500">
                            Rating:
                            <span class="font-semibold">
                                {{ $h->rating ?? '-' }}
                            </span>
                        </div>

                        <h3 class="mt-1 text-lg font-semibold">
                            {{ $h->nama }}
                        </h3>

                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit($h->deskripsi ?? '', 110) }}
                        </p>

                        <div class="mt-4 flex gap-2">
                            <a href="/homestay/{{ $h->slug }}"
                               class="px-3 py-2 rounded bg-black text-white text-sm">
                                Detail
                            </a>

                            @if(!empty($h->maps_link))
                                <a href="{{ $h->maps_link }}"
                                   target="_blank"
                                   class="px-3 py-2 rounded border text-sm">
                                    Maps
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    @else
        <div class="mt-6 p-6 bg-white rounded border text-gray-600">
            Belum ada data homestay.
        </div>
    @endif

</div>


</div>
@endsection
