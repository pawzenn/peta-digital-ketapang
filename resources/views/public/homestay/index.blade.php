@extends('layouts.public')

@section('title', 'Homestay - Peta Digital Ketapang')

@section('content')
<div class="mx-auto max-w-7xl px-6 py-16">

    <h1 class="text-center text-3xl font-bold text-emerald-900">Homestay Desa Ketapang</h1>

    <div class="mt-10 grid gap-6 md:grid-cols-3">
        @forelse($homestays as $h)
            <x-public.card
                :nama="$h->nama"
                :deskripsi="$h->deskripsi"
                :cover-url="$h->cover_foto ? asset('storage/'.$h->cover_foto) : null"
                :detail-url="'/homestay/'.$h->slug"
                :rating="$h->rating"
            />
        @empty
            <div class="col-span-3 rounded-xl border bg-white p-6 text-center text-neutral-500">
                Belum ada data homestay.
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $homestays->links() }}
    </div>

</div>
@endsection
