@extends('layouts.admin')

@section('page_title', 'Data UMKM')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- HEADER + FILTER --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">

            <h1 class="text-xl font-semibold">Data UMKM</h1>

            {{-- FILTER KATEGORI --}}
            <form method="GET" action="{{ route('admin.umkm.index') }}">
                <select name="kategori"
                        onchange="this.form.submit()"
                        class="border rounded px-3 py-2 text-sm">

                    <option value="">Semua Kategori</option>

                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}"
                            @selected(request('kategori') == $kat->id)>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>
            </form>

            {{-- RESET FILTER --}}
            @if(request('kategori'))
                <a href="{{ route('admin.umkm.index') }}"
                   class="text-sm underline text-gray-600">
                    Reset
                </a>
            @endif

        </div>

        <a href="{{ route('admin.umkm.create') }}"
           class="px-4 py-2 rounded bg-black text-white">
            + Tambah UMKM
        </a>
    </div>

    {{-- SUCCESS ALERT --}}
    @if(session('success'))
        <div class="p-4 rounded border bg-green-50 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left p-3">Cover</th>
                    <th class="text-left p-3">Nama</th>
                    <th class="text-left p-3">Kategori</th>
                    <th class="text-left p-3">Rating</th>
                    <th class="text-left p-3">Updated</th>
                    <th class="text-right p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($umkms as $umkm)
                    <tr class="border-t">
                        <td class="p-3">
                            @if($umkm->cover_foto)
                                <img src="{{ asset('storage/' . $umkm->cover_foto) }}"
                                     class="w-28 h-16 object-cover rounded border" alt="cover">
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>

                        <td class="p-3">
                            <div class="font-medium">{{ $umkm->nama }}</div>
                            <div class="text-gray-500">{{ $umkm->slug }}</div>
                        </td>

                        <td class="p-3">
                            {{ $umkm->kategori?->nama ?? '-' }}
                        </td>

                        <td class="p-3">{{ $umkm->rating ?? '-' }}</td>

                        <td class="p-3">
                            {{ $umkm->updated_at?->format('d M Y H:i') }}
                        </td>

                        <td class="p-3 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.umkm.edit', $umkm) }}"
                                   class="px-3 py-1 rounded border">
                                   Edit
                                </a>

                                <form action="{{ route('admin.umkm.destroy', $umkm) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus UMKM ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 rounded border text-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="p-6 text-center text-gray-500" colspan="6">
                            Belum ada data UMKM.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="p-4">
            {{ $umkms->links() ?? '' }}
        </div>
    </div>

</div>
@endsection
