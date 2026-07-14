@extends('layouts.public')

@section('title', 'Profil Desa - Peta Digital Ketapang')

@section('content')
<div class="mx-auto max-w-5xl px-6 py-16">
    <h1 class="font-serif text-3xl font-bold text-emerald-900">
        {{ $profil->nama ?? 'Profil Desa Ketapang' }}
    </h1>

    @if(!empty($profil?->peta_wilayah))
        <div class="mt-6">
            <img
                src="{{ asset('storage/' . $profil->peta_wilayah) }}"
                alt="Peta Wilayah"
                class="w-full rounded-xl border bg-white"
            >
        </div>
    @endif

    <p class="mt-6 whitespace-pre-line leading-relaxed text-neutral-700">
        {{ $profil->deskripsi ?? 'Belum ada deskripsi profil desa. Silakan isi melalui panel admin.' }}
    </p>
</div>
@endsection
