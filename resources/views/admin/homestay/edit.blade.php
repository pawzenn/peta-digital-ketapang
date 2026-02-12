@extends('layouts.admin')

@section('title', 'Edit Homestay - Admin')

@section('page_title', 'Edit Homestay')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold">Edit Homestay</h1>
        <a href="{{ route('admin.homestay.index') }}" class="text-sm underline">Kembali</a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded border bg-green-50 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded border p-6">
        <form
            action="{{ route('admin.homestay.update', $homestay) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            @include('admin.homestay._form', ['homestay' => $homestay])

            <div class="flex gap-3">
                <button type="submit" class="px-4 py-2 rounded bg-black text-white">
                    Update
                </button>
                <a href="{{ route('admin.homestay.index') }}" class="px-4 py-2 rounded border">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
