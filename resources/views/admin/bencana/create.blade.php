@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold">Tambah Data Bencana</h1>
        <a href="{{ route('admin.bencana.index') }}" class="text-sm underline">Kembali</a>
    </div>

    <div class="bg-white rounded border p-6">
        <form
            action="{{ route('admin.bencana.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf

            @include('admin.bencana._form')

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 rounded bg-black text-white">
                    Simpan
                </button>
                <a href="{{ route('admin.bencana.index') }}" class="px-4 py-2 rounded border">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
