@extends('layouts.admin')

@section('page_title','Tambah Kategori UMKM')

@section('content')
<form method="POST" action="{{ route('admin.kategori-umkm.store') }}">
@csrf

<input name="nama" class="border p-2 w-full" placeholder="Nama kategori">

<button class="mt-4 px-4 py-2 bg-black text-white">Simpan</button>
</form>
@endsection
