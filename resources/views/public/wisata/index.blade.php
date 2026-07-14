@extends('layouts.public')

@section('title', 'Wisata - Peta Digital Ketapang')

@section('content')
<div class="mx-auto max-w-7xl px-6 py-16">

    <h1 class="text-center text-3xl font-bold text-emerald-900">Wisata Desa Ketapang</h1>

    <div class="mt-10 grid gap-6 md:grid-cols-3">
        @forelse($wisatas as $w)
            <x-public.card
                :nama="$w->nama"
                :deskripsi="$w->deskripsi"
                :cover-url="$w->cover_foto ? asset('storage/'.$w->cover_foto) : null"
                :detail-url="'/wisata/'.$w->slug"
                :rating="$w->rating"
            />
        @empty
            <div class="col-span-3 rounded-xl border bg-white p-6 text-center text-neutral-500">
                Belum ada data wisata.
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $wisatas->links() }}
    </div>

</div>
@endsection
