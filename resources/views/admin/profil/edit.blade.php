@extends('layouts.admin')

@section('page_title','Profil Desa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <h1 class="text-xl font-semibold">Profil Desa</h1>

    @if(session('success'))
        <div class="p-4 rounded border bg-green-50 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded border p-6">
        <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-4">

                <div>
                    <label class="block text-sm font-medium mb-1">Nama</label>
                    <input type="text" name="nama"
                           value="{{ old('nama',$profil->nama) }}"
                           class="w-full border rounded px-3 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi"
                              class="w-full border rounded px-3 py-2"
                              rows="5">{{ old('deskripsi',$profil->deskripsi) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Peta Wilayah (JPG)</label>
                    <input type="file" name="peta_wilayah" accept=".jpg,.jpeg"
                           class="w-full border rounded px-3 py-2">

                    @if($profil->peta_wilayah)
                        <img src="{{ asset('storage/'.$profil->peta_wilayah) }}"
                             class="mt-3 w-full max-w-md border rounded">
                    @endif
                </div>

                <button class="px-4 py-2 bg-black text-white rounded">
                    Simpan
                </button>

            </div>

        </form>
    </div>

</div>
@endsection
