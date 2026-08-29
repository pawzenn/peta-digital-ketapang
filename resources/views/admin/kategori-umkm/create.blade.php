@extends('layouts.admin')

@section('page_title', 'Tambah Kategori UMKM')
@section('page_subtitle', 'Buat kategori baru untuk pengelompokan data UMKM')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-neutral-900">Tambah Kategori UMKM</h1>
        <a href="{{ route('admin.kategori-umkm.index') }}" class="text-sm font-medium text-neutral-500 hover:text-emerald-800 hover:underline">Kembali</a>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('admin.kategori-umkm.store') }}" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="nama" value="Nama Kategori" />
                <x-text-input id="nama" name="nama" type="text" class="mt-1.5 block w-full"
                    value="{{ old('nama') }}" placeholder="Contoh: Kuliner, Kerajinan, Jasa" required autofocus />
                <x-input-error :messages="$errors->get('nama')" class="mt-1.5" />
            </div>

            <div class="flex gap-3">
                <button class="inline-flex items-center rounded-lg bg-emerald-800 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-900">
                    Simpan
                </button>
                <a href="{{ route('admin.kategori-umkm.index') }}" class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-50">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
