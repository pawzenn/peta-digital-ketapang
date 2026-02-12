@extends('layouts.admin')

@section('page_title','Kategori UMKM')

@section('content')
<div class="space-y-6">

    <div class="flex justify-between">
        <h1 class="text-xl font-semibold">Kategori UMKM</h1>
        <a href="{{ route('admin.kategori-umkm.create') }}"
           class="px-4 py-2 bg-black text-white rounded">
           + Tambah Kategori
        </a>
    </div>

    @foreach($kategoris as $kat)
        <div class="p-4 border rounded flex justify-between">
            <div>
                <div class="font-semibold">{{ $kat->nama }}</div>
                <div class="text-sm text-gray-500">{{ $kat->slug }}</div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.kategori-umkm.edit',$kat) }}">Edit</a>

                <form method="POST" action="{{ route('admin.kategori-umkm.destroy',$kat) }}">
                    @csrf
                    @method('DELETE')
                    <button>Hapus</button>
                </form>
            </div>
        </div>
    @endforeach

</div>
@endsection
