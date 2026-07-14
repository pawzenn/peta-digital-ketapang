@extends('layouts.public')

@section('title', 'UMKM - Peta Digital Ketapang')

@section('content')
<div class="mx-auto max-w-7xl px-6 py-16">

    <h1 class="text-center text-3xl font-bold text-emerald-900">Usaha Mikro Kecil Menengah</h1>

    @if($kategoris->count())
        <div class="mt-8 flex flex-wrap justify-center gap-2">
            <a href="/umkm"
               class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors {{ request('kategori') ? 'bg-white text-neutral-700 ring-1 ring-black/10 hover:bg-emerald-50' : 'bg-emerald-900 text-white' }}">
                Semua
            </a>

            @foreach($kategoris as $kategori)
                <a href="{{ request()->fullUrlWithQuery(['kategori' => $kategori->id]) }}"
                   class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors {{ (string) request('kategori') === (string) $kategori->id ? 'bg-emerald-900 text-white' : 'bg-white text-neutral-700 ring-1 ring-black/10 hover:bg-emerald-50' }}">
                    {{ $kategori->nama }}
                </a>
            @endforeach
        </div>
    @endif

    <div class="mt-10 grid gap-6 md:grid-cols-3">
        @forelse($umkms as $u)
            <x-public.card
                :nama="$u->nama"
                :deskripsi="$u->deskripsi"
                :cover-url="$u->cover_foto ? asset('storage/'.$u->cover_foto) : null"
                :detail-url="'/umkm/'.$u->slug"
                :rating="$u->rating"
                :badge="$u->kategori?->nama"
            />
        @empty
            <div class="col-span-3 rounded-xl border bg-white p-6 text-center text-neutral-500">
                Belum ada data UMKM.
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $umkms->links() }}
    </div>

</div>
@endsection
