@extends('layouts.admin')

@section('page_title', 'Edit Data Bencana')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-neutral-900">Edit Data Bencana</h1>
        <a href="{{ route('admin.bencana.index') }}" class="text-sm font-medium text-neutral-500 hover:text-emerald-800 hover:underline">Kembali</a>
    </div>

    <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
        <form
            action="{{ route('admin.bencana.update', $bencana) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            @include('admin.bencana._form', ['bencana' => $bencana])

            <div class="flex gap-3">
                <button type="submit" class="inline-flex items-center rounded-lg bg-emerald-800 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-900">
                    Update
                </button>
                <a href="{{ route('admin.bencana.index') }}" class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition hover:bg-neutral-50">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
