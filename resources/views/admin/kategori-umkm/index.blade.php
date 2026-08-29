@extends('layouts.admin')

@section('page_title', 'Kategori UMKM')
@section('page_subtitle', 'Kelola kategori untuk pengelompokan data UMKM')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-neutral-900">Kategori UMKM</h1>
        <a href="{{ route('admin.kategori-umkm.create') }}"
           class="inline-flex items-center rounded-lg bg-emerald-800 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-900">
            + Tambah Kategori
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm">
        @forelse($kategoris as $kat)
            <div class="flex items-center justify-between border-t border-neutral-100 px-5 py-4 first:border-t-0 hover:bg-neutral-50/60">
                <div>
                    <div class="font-medium text-neutral-900">{{ $kat->nama }}</div>
                    <div class="text-sm text-neutral-400">{{ $kat->slug }}</div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.kategori-umkm.edit', $kat) }}"
                       class="rounded-lg border border-neutral-300 px-3 py-1.5 text-sm font-medium text-neutral-700 transition hover:bg-neutral-50">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('admin.kategori-umkm.destroy', $kat) }}"
                          onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="rounded-lg border border-red-200 px-3 py-1.5 text-sm font-medium text-red-600 transition hover:bg-red-50">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-neutral-400">
                Belum ada kategori UMKM.
            </div>
        @endforelse

        <div class="border-t border-neutral-100 px-5 py-4">
            {{ $kategoris->links() }}
        </div>
    </div>

</div>
@endsection
