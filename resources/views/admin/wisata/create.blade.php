@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold">Tambah Wisata</h1>
        <a href="{{ route('admin.wisata.index') }}" class="text-sm underline">Kembali</a>
    </div>

    <div class="bg-white rounded border p-6">
        <form
            action="{{ route('admin.wisata.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf

            @include('admin.wisata._form')

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 rounded bg-black text-white">
                    Simpan
                </button>
                <a href="{{ route('admin.wisata.index') }}" class="px-4 py-2 rounded border">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
