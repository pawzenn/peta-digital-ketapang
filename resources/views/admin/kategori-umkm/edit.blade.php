@extends('layouts.admin')

@section('page_title','Edit Kategori UMKM')

@section('content')
<form method="POST" action="{{ route('admin.kategori-umkm.update',$kategori) }}">
@csrf
@method('PUT')

<input name="nama" value="{{ $kategori->nama }}" class="border p-2 w-full">

<button class="mt-4 px-4 py-2 bg-black text-white">Update</button>
</form>
@endsection
