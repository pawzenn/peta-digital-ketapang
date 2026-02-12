@extends('layouts.public')

@section('title', $wisata->nama.' - Wisata')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-16">

    <a href="/wisata" class="text-sm underline">← Kembali</a>

    <h1 class="text-3xl font-bold mt-4">
        {{ $wisata->nama }}
    </h1>

    <div class="text-sm text-gray-500 mt-1">
        Rating: {{ $wisata->rating ?? '-' }}
    </div>

    {{-- COVER --}}
    @if($wisata->cover_foto)
        <img
            src="{{ asset('storage/'.$wisata->cover_foto) }}"
            class="mt-6 w-full rounded border"
        >
    @endif

    {{-- DESKRIPSI --}}
    <p class="mt-6 text-gray-700 whitespace-pre-line">
        {{ $wisata->deskripsi }}
    </p>

    {{-- ALAMAT --}}
    @if($wisata->alamat)
        <div class="mt-6">
            <strong>Alamat:</strong> {{ $wisata->alamat }}
        </div>
    @endif

    {{-- MAPS --}}
    @if($wisata->maps_link)
        <div class="mt-4">
            <a href="{{ $wisata->maps_link }}" target="_blank"
               class="px-4 py-2 bg-black text-white rounded">
                Buka Maps
            </a>
        </div>
    @endif

    {{-- GALLERY --}}
    @if($wisata->galleries->count())
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Gallery</h2>

            <div class="grid md:grid-cols-3 gap-4">
                @foreach($wisata->galleries as $foto)
                    <img
                        src="{{ asset('storage/'.$foto->file_path) }}"
                        class="w-full h-40 object-cover rounded border"
                    >
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
