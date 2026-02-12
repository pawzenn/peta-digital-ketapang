@extends('layouts.admin')

@section('page_title', 'Edit UMKM')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold">Edit UMKM</h1>
        <a href="{{ route('admin.umkm.index') }}" class="text-sm underline">Kembali</a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded border bg-green-50 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded border p-6">
        <form action="{{ route('admin.umkm.update', $umkm) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            @include('admin.umkm._form', ['umkm' => $umkm, 'kategoris' => $kategoris])
            <div class="flex gap-3">
                <button class="px-4 py-2 rounded bg-black text-white">Update</button>
                <a href="{{ route('admin.umkm.index') }}" class="px-4 py-2 rounded border">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
