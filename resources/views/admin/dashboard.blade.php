@extends('layouts.admin')

@section('title', 'Dashboard Admin - Peta Digital Ketapang')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan pengelolaan konten')

@section('content')
<div class="grid grid-cols-3 gap-6">
    <div class="bg-white border rounded p-5">
        <div class="text-sm text-gray-500">Wisata</div>
        <div class="mt-2 text-2xl font-bold">0</div>
    </div>

    <div class="bg-white border rounded p-5">
        <div class="text-sm text-gray-500">Homestay</div>
        <div class="mt-2 text-2xl font-bold">0</div>
    </div>

    <div class="bg-white border rounded p-5">
        <div class="text-sm text-gray-500">UMKM</div>
        <div class="mt-2 text-2xl font-bold">0</div>
    </div>
</div>

<div class="mt-6 bg-white border rounded p-5">
    <h2 class="font-semibold">Catatan</h2>
    <p class="text-sm text-gray-600 mt-2">
        Ini masih placeholder. Setelah modul CRUD dibuat, angka-angka akan diambil dari database.
    </p>
</div>
@endsection
