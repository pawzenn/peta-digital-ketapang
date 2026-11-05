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

                <x-public.award-badges :awards="$umkm->penghargaans" compact />
            </div>
        </div>

        <x-public.gallery :images="$umkm->galleries" />

        <x-public.video-reviews :videos="$umkm->videoReviews" />

        {{-- RUTE --}}
        <div class="mt-14 grid gap-8 md:grid-cols-2 md:items-center">
            <div>
                <h2 class="text-xl font-bold">Rute</h2>

                @if($umkm->alamat)
                    <p class="mt-4 text-sm leading-relaxed text-white/80">
                        {{ $umkm->alamat }}
                    </p>
                @endif

                @if($umkm->maps_link || $umkm->video_rute_link)
                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        @if($umkm->maps_link)
                            <a href="{{ $umkm->maps_link }}" target="_blank"
                               class="inline-block rounded-md bg-white px-4 py-2 text-sm font-semibold text-neutral-900">
                                Buka Maps
                            </a>
                        @endif

                        <x-public.video-route :link="$umkm->video_rute_link" :embed="$umkm->video_rute_embed_url" />
                    </div>
                @endif
            </div>

            @if($umkm->foto_rute)
                <img
                    src="{{ asset('storage/'.$umkm->foto_rute) }}"
                    class="h-64 w-full rounded-xl border border-white/10 object-cover"
                    alt="Rute {{ $umkm->nama }}"
                >
            @elseif($umkm->maps_embed_url)
                <iframe
                    src="{{ $umkm->maps_embed_url }}"
                    class="h-64 w-full rounded-xl border border-white/10"
                    style="border:0"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen
                ></iframe>
            @else
                <div class="flex h-64 items-center justify-center rounded-xl border border-white/10 bg-neutral-800 text-neutral-500">
                    Belum ada info rute
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
