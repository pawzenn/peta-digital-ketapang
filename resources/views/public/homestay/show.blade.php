@extends('layouts.public')

@section('title', $homestay->nama.' - Homestay')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-16">

    <a href="/homestay" class="text-sm underline">← Kembali</a>

    <h1 class="text-3xl font-bold mt-4">
        {{ $homestay->nama }}
    </h1>

    <div class="text-sm text-gray-500 mt-1">
        Rating: {{ $homestay->rating ?? '-' }}
    </div>

    {{-- COVER --}}
    @if($homestay->cover_foto)
        <img
            src="{{ asset('storage/'.$homestay->cover_foto) }}"
            class="mt-6 w-full rounded border"
        >
    @endif

    {{-- DESKRIPSI --}}
    <p class="mt-6 text-gray-700 whitespace-pre-line">
        {{ $homestay->deskripsi }}
    </p>

    {{-- ALAMAT --}}
    @if($homestay->alamat)
        <div class="mt-6">
            <strong>Alamat:</strong> {{ $homestay->alamat }}
        </div>
    @endif

    {{-- MAPS --}}
    @if($homestay->maps_link)
        <div class="mt-4">
            <a href="{{ $homestay->maps_link }}" target="_blank"
               class="px-4 py-2 bg-black text-white rounded">
                Buka Maps
            </a>
        </div>
    @endif

    {{-- GALLERY --}}
    @if($homestay->galleries->count())
        <div class="mt-10">
            <h2 class="text-xl font-semibold mb-4">Gallery</h2>

            <div class="grid md:grid-cols-3 gap-4">
                @foreach($homestay->galleries as $foto)
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
