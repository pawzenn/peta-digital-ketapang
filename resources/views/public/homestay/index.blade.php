@extends('layouts.public')

@section('title', 'Homestay - Peta Digital Ketapang')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16">

    <h1 class="text-3xl font-bold">Homestay</h1>

    <div class="mt-8 grid md:grid-cols-3 gap-6">

        @forelse($homestays as $h)
            <div class="bg-white rounded border overflow-hidden hover:shadow-md transition">

                <div class="bg-gray-100">
                    @if($h->cover_foto)
                        <img
                            src="{{ asset('storage/'.$h->cover_foto) }}"
                            class="w-full h-44 object-cover"
                        >
                    @endif
                </div>

                <div class="p-4">

                    <div class="text-xs text-gray-500">
                        Rating: {{ $h->rating ?? '-' }}
                    </div>

                    <h3 class="mt-1 font-semibold text-lg">
                        {{ $h->nama }}
                    </h3>

                    <p class="text-sm text-gray-600 mt-2">
                        {{ \Illuminate\Support\Str::limit($h->deskripsi,120) }}
                    </p>

                    <a href="/homestay/{{ $h->slug }}"
                       class="inline-block mt-4 px-3 py-2 bg-black text-white rounded text-sm">
                        Detail
                    </a>

                </div>
            </div>
        @empty
            <div class="col-span-3 text-gray-500">
                Belum ada data homestay.
            </div>
        @endforelse

    </div>

    <div class="mt-8">
        {{ $homestays->links() }}
    </div>

</div>
@endsection
