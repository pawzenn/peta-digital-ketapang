@extends('layouts.public')

@section('title', $wisata->nama.' - Wisata')

@section('content')
<div class="bg-neutral-950 py-16 text-white">
    <div class="mx-auto max-w-6xl px-6">

        <a href="/wisata" class="text-sm text-white/70 hover:text-white">← Kembali</a>

        <div class="relative mt-6 overflow-hidden rounded-2xl">
            @if($wisata->cover_foto)
                <img
                    src="{{ asset('storage/'.$wisata->cover_foto) }}"
                    class="h-[420px] w-full object-cover"
                    alt="{{ $wisata->nama }}"
                >
            @else
                <div class="flex h-[420px] items-center justify-center bg-neutral-800 text-neutral-400">
                    Tidak ada foto
                </div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-l from-black/10 via-black/60 to-transparent"></div>

            <div class="absolute inset-y-0 right-0 flex w-full max-w-md flex-col justify-center px-8">
                <h1 class="font-serif text-3xl font-bold">{{ $wisata->nama }}</h1>

                <div class="mt-3">
                    <x-public.rating-badge :rating="$wisata->rating" />
                </div>

                <p class="mt-4 text-sm leading-relaxed text-white/85">
                    {{ $wisata->deskripsi }}
                </p>
            </div>
        </div>

        {{-- RUTE --}}
        <div class="mt-14 grid gap-8 md:grid-cols-2 md:items-center">
            <div>
                <h2 class="text-xl font-bold">Rute</h2>

                @if($wisata->alamat)
                    <p class="mt-4 text-sm leading-relaxed text-white/80">
                        {{ $wisata->alamat }}
                    </p>
                @endif

                @if($wisata->maps_link)
                    <a href="{{ $wisata->maps_link }}" target="_blank"
                       class="mt-4 inline-block rounded-md bg-white px-4 py-2 text-sm font-semibold text-neutral-900">
                        Buka Maps
                    </a>
                @endif
            </div>

            @if($wisata->foto_rute)
                <img
                    src="{{ asset('storage/'.$wisata->foto_rute) }}"
                    class="h-64 w-full rounded-xl border border-white/10 object-cover"
                    alt="Rute {{ $wisata->nama }}"
                >
            @else
                <div class="flex h-64 items-center justify-center rounded-xl border border-white/10 bg-neutral-800 text-neutral-500">
                    Belum ada foto rute
                </div>
            @endif
        </div>

        <x-public.gallery :images="$wisata->galleries" />

    </div>
</div>
@endsection
