@extends('layouts.admin')

@section('title', 'Dashboard Admin - Peta Digital Ketapang')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan pengelolaan konten')

@section('content')

@php
    $icons = [
        'wisata' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21" />',
        'homestay' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />',
        'umkm' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.09-2.577 2.25-6.75H5.106M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />',
        'kategori' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />',
        'bencana' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />',
    ];

    $stats = [
        ['label' => 'Wisata', 'value' => $counts['wisata'], 'route' => 'admin.wisata.index', 'icon' => 'wisata', 'bg' => 'bg-emerald-50', 'fg' => 'text-emerald-700'],
        ['label' => 'Homestay', 'value' => $counts['homestay'], 'route' => 'admin.homestay.index', 'icon' => 'homestay', 'bg' => 'bg-orange-50', 'fg' => 'text-orange-700'],
        ['label' => 'UMKM', 'value' => $counts['umkm'], 'route' => 'admin.umkm.index', 'icon' => 'umkm', 'bg' => 'bg-amber-50', 'fg' => 'text-amber-700'],
        ['label' => 'Kategori UMKM', 'value' => $counts['kategori_umkm'], 'route' => 'admin.kategori-umkm.index', 'icon' => 'kategori', 'bg' => 'bg-sky-50', 'fg' => 'text-sky-700'],
        ['label' => 'Bencana', 'value' => $counts['bencana'], 'route' => 'admin.bencana.index', 'icon' => 'bencana', 'bg' => 'bg-red-50', 'fg' => 'text-red-700'],
    ];
@endphp

<div class="grid grid-cols-2 gap-4 md:grid-cols-5">
    @foreach($stats as $stat)
        <a href="{{ route($stat['route']) }}" class="group rounded-xl border border-neutral-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg {{ $stat['bg'] }} {{ $stat['fg'] }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" class="h-5 w-5">
                        {!! $icons[$stat['icon']] !!}
                    </svg>
                </span>
                <span class="text-sm font-medium text-neutral-500">{{ $stat['label'] }}</span>
            </div>
            <div class="mt-4 flex items-end justify-between">
                <div class="text-3xl font-bold text-neutral-900">{{ $stat['value'] }}</div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" class="h-4 w-4 text-neutral-300 transition group-hover:translate-x-0.5 group-hover:text-emerald-700">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </div>
        </a>
    @endforeach
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-3">
    <div class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-neutral-900">Wisata Terbaru</h2>
            <a href="{{ route('admin.wisata.index') }}" class="text-xs font-medium text-emerald-800 hover:underline">Lihat semua</a>
        </div>

        <ul class="mt-4 space-y-3">
            @forelse($recentWisata as $item)
                <li class="flex items-center gap-3">
                    @if($item->cover_foto)
                        <img src="{{ asset('storage/'.$item->cover_foto) }}" class="h-10 w-14 shrink-0 rounded-md border border-neutral-200 object-cover" alt="">
                    @else
                        <div class="flex h-10 w-14 shrink-0 items-center justify-center rounded-md bg-neutral-100 text-neutral-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0A2.25 2.25 0 015.25 6h13.5A2.25 2.25 0 0121 8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25" />
                            </svg>
                        </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-sm text-neutral-700">{{ $item->nama }}</div>
                        <div class="text-xs text-neutral-400">{{ $item->updated_at?->diffForHumans() }}</div>
                    </div>
                </li>
            @empty
                <li class="text-sm text-neutral-400">Belum ada data.</li>
            @endforelse
        </ul>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-neutral-900">Homestay Terbaru</h2>
            <a href="{{ route('admin.homestay.index') }}" class="text-xs font-medium text-emerald-800 hover:underline">Lihat semua</a>
        </div>

        <ul class="mt-4 space-y-3">
            @forelse($recentHomestay as $item)
                <li class="flex items-center gap-3">
                    @if($item->cover_foto)
                        <img src="{{ asset('storage/'.$item->cover_foto) }}" class="h-10 w-14 shrink-0 rounded-md border border-neutral-200 object-cover" alt="">
                    @else
                        <div class="flex h-10 w-14 shrink-0 items-center justify-center rounded-md bg-neutral-100 text-neutral-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0A2.25 2.25 0 015.25 6h13.5A2.25 2.25 0 0121 8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25" />
                            </svg>
                        </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-sm text-neutral-700">{{ $item->nama }}</div>
                        <div class="text-xs text-neutral-400">{{ $item->updated_at?->diffForHumans() }}</div>
                    </div>
                </li>
            @empty
                <li class="text-sm text-neutral-400">Belum ada data.</li>
            @endforelse
        </ul>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-neutral-900">UMKM Terbaru</h2>
            <a href="{{ route('admin.umkm.index') }}" class="text-xs font-medium text-emerald-800 hover:underline">Lihat semua</a>
        </div>

        <ul class="mt-4 space-y-3">
            @forelse($recentUmkm as $item)
                <li class="flex items-center gap-3">
                    @if($item->cover_foto)
                        <img src="{{ asset('storage/'.$item->cover_foto) }}" class="h-10 w-14 shrink-0 rounded-md border border-neutral-200 object-cover" alt="">
                    @else
                        <div class="flex h-10 w-14 shrink-0 items-center justify-center rounded-md bg-neutral-100 text-neutral-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25m-18 0A2.25 2.25 0 015.25 6h13.5A2.25 2.25 0 0121 8.25m-18 0V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v2.25" />
                            </svg>
                        </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-sm text-neutral-700">{{ $item->nama }}</div>
                        <div class="text-xs text-neutral-400">{{ $item->kategori?->nama ?? '-' }}</div>
                    </div>
                </li>
            @empty
                <li class="text-sm text-neutral-400">Belum ada data.</li>
            @endforelse
        </ul>
    </div>
</div>

@endsection
