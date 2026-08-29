@extends('layouts.public')

@section('title', 'Profil Desa - Peta Digital Ketapang')

@section('content')
<div class="mx-auto max-w-5xl px-6 py-16">
    @php $paragraphs = $profil->deskripsi_paragraphs ?? []; @endphp

    <div class="grid gap-10 md:grid-cols-[1fr_1.35fr] md:items-start">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-600">Profil Desa</p>
            <h1 class="mt-2 font-serif text-3xl font-bold text-emerald-900">
                {{ $profil->nama ?? 'Profil Desa Ketapang' }}
            </h1>

            @if(empty($paragraphs))
                <p class="mt-4 leading-loose text-neutral-600">
                    Belum ada deskripsi profil desa. Silakan isi melalui panel admin.
                </p>
            @elseif(isset($paragraphs[0]))
                <p class="mt-4 text-justify leading-loose text-neutral-600 first-letter:float-left first-letter:mr-2 first-letter:font-serif first-letter:text-5xl first-letter:font-bold first-letter:leading-[0.85] first-letter:text-emerald-800">
                    {{ $paragraphs[0] }}
                </p>
            @endif
        </div>

        @if(!empty($profil?->peta_wilayah))
            <img
                src="{{ asset('storage/' . $profil->peta_wilayah) }}"
                alt="Peta Wilayah"
                class="w-full md:mt-28"
            >
        @endif
    </div>

    @if(count($paragraphs) > 1)
        <div class="mt-8 space-y-4">
            @foreach(array_slice($paragraphs, 1) as $paragraf)
                <p class="text-justify leading-loose text-neutral-600">{{ $paragraf }}</p>
            @endforeach
        </div>
    @endif

    @if($profil?->kepala_desa_nama || $profil?->visi || count($profil?->misi_list ?? []))
        <div class="mt-24">
            <div class="grid gap-12 md:grid-cols-[0.85fr_1.15fr] md:items-start">

                <div class="text-center md:text-left">
                    @if($profil->kepala_desa_foto)
                        <img src="{{ asset('storage/'.$profil->kepala_desa_foto) }}"
                             alt="{{ $profil->kepala_desa_nama }}"
                             class="mx-auto h-56 w-56 rounded-full border-4 border-white object-cover shadow-md md:mx-0">
                    @endif

                    <p class="mt-5 text-sm font-medium text-neutral-500">{{ $profil->kepala_desa_jabatan ?: 'Kepala Desa' }}</p>
                    <p class="mt-1 font-serif text-xl font-bold text-emerald-900">{{ $profil->kepala_desa_nama }}</p>
                    <p class="text-sm text-neutral-500">{{ $profil->nama ?? 'Desa Ketapang' }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-600">Arah & Tujuan</p>
                    <h2 class="mt-2 font-serif text-2xl font-bold text-emerald-900">Visi &amp; Misi Desa</h2>

                    @if($profil->visi)
                        <div class="mt-5 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
                            <h3 class="font-serif text-lg font-bold text-emerald-800">Visi</h3>
                            <p class="mt-3 leading-relaxed text-neutral-600">&ldquo;{{ $profil->visi }}&rdquo;</p>
                        </div>
                    @endif

                    @if(count($profil->misi_list))
                        <div class="mt-5 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
                            <h3 class="font-serif text-lg font-bold text-emerald-800">Misi</h3>
                            <ul class="mt-3 space-y-2.5">
                                @foreach($profil->misi_list as $i => $poin)
                                    <li class="flex items-start gap-2 leading-relaxed text-neutral-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="mt-0.5 h-5 w-5 shrink-0 text-emerald-700">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        <span>{{ chr(97 + $i) }}. {{ $poin }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    @endif
</div>
@endsection
