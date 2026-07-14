@extends('layouts.public')

@section('title', $umkm->nama.' - UMKM')

@section('content')
<div class="bg-neutral-950 py-16 text-white">
    <div class="mx-auto max-w-6xl px-6">

        <a href="/umkm" class="text-sm text-white/70 hover:text-white">← Kembali</a>

        <div class="relative mt-6 overflow-hidden rounded-2xl">
            @if($umkm->cover_foto)
                <img
                    src="{{ asset('storage/'.$umkm->cover_foto) }}"
                    class="h-[420px] w-full object-cover"
                    alt="{{ $umkm->nama }}"
                >
            @else
                <div class="flex h-[420px] items-center justify-center bg-neutral-800 text-neutral-400">
                    Tidak ada foto
                </div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-l from-black/10 via-black/60 to-transparent"></div>

            <div class="absolute inset-y-0 right-0 flex w-full max-w-md flex-col justify-center px-8">
                @if($umkm->kategori)
                    <span class="mb-3 inline-block w-fit rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-neutral-800">
                        {{ $umkm->kategori->nama }}
                    </span>
                @endif

                <h1 class="font-serif text-3xl font-bold">{{ $umkm->nama }}</h1>

                <div class="mt-3">
                    <x-public.rating-badge :rating="$umkm->rating" />
                </div>

                <p class="mt-4 text-sm leading-relaxed text-white/85">
                    {{ $umkm->deskripsi }}
                </p>
            </div>
        </div>

        {{-- LOKASI --}}
        @if($umkm->alamat || $umkm->maps_link)
            <div class="mt-10">
                <h2 class="text-xl font-bold">Lokasi</h2>

                @if($umkm->alamat)
                    <p class="mt-4 text-sm leading-relaxed text-white/80">
                        {{ $umkm->alamat }}
                    </p>
                @endif

                @if($umkm->maps_link)
                    <a href="{{ $umkm->maps_link }}" target="_blank"
                       class="mt-4 inline-block rounded-md bg-white px-4 py-2 text-sm font-semibold text-neutral-900">
                        Buka Maps
                    </a>
                @endif
            </div>
        @endif

        <x-public.gallery :images="$umkm->galleries" />

    </div>
</div>
@endsection
