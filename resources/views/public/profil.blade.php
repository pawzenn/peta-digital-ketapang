@extends('layouts.public')

@section('title', 'Profil Desa - Peta Digital Ketapang')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-16">
    <h1 class="text-3xl font-bold">
        {{ $profil->nama ?? 'Profil Desa Ketapang' }}
    </h1>

    @if(!empty($profil?->peta_wilayah))
        <div class="mt-6">
            <img
                src="{{ asset('storage/' . $profil->peta_wilayah) }}"
                alt="Peta Wilayah"
                class="w-full rounded border bg-white"
            >
        </div>
    @endif

    <p class="mt-6 text-gray-700 leading-relaxed whitespace-pre-line">
        {{ $profil->deskripsi ?? 'Belum ada deskripsi profil desa. Silakan isi melalui panel admin.' }}
    </p>
</div>
@endsection
