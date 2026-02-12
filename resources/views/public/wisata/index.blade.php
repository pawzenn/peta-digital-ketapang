@extends('layouts.public')

@section('title', 'Wisata - Peta Digital Ketapang')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16">

    <h1 class="text-3xl font-bold">Daftar Wisata</h1>

    <div class="mt-8 grid md:grid-cols-3 gap-6">

        @forelse($wisatas as $w)
            <div class="bg-white rounded border overflow-hidden hover:shadow-md transition">

                <div class="bg-gray-100">
                    @if($w->cover_foto)
                        <img
                            src="{{ asset('storage/'.$w->cover_foto) }}"
                            class="w-full h-44 object-cover"
                        >
                    @endif
                </div>

                <div class="p-4">

                    <div class="text-xs text-gray-500">
                        Rating: {{ $w->rating ?? '-' }}
                    </div>

                    <h3 class="mt-1 font-semibold text-lg">
                        {{ $w->nama }}
                    </h3>

                    <p class="text-sm text-gray-600 mt-2">
                        {{ \Illuminate\Support\Str::limit($w->deskripsi,120) }}
                    </p>

                    <a href="/wisata/{{ $w->slug }}"
                       class="inline-block mt-4 px-3 py-2 bg-black text-white rounded text-sm">
                        Detail
                    </a>

                </div>
            </div>
        @empty
            <div class="col-span-3 text-gray-500">
                Belum ada data wisata.
            </div>
        @endforelse

    </div>

    <div class="mt-8">
        {{ $wisatas->links() }}
    </div>

</div>
@endsection
