@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold">Data Wisata</h1>
        <a href="{{ route('admin.wisata.create') }}" class="px-4 py-2 rounded bg-black text-white">
            + Tambah Wisata
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded border bg-green-50 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left p-3">Cover</th>
                    <th class="text-left p-3">Nama</th>
                    <th class="text-left p-3">Rating</th>
                    <th class="text-left p-3">Updated</th>
                    <th class="text-right p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wisatas as $wisata)
                    <tr class="border-t">
                        <td class="p-3">
                            @if($wisata->cover_foto)
                                <img
                                    src="{{ asset('storage/' . $wisata->cover_foto) }}"
                                    class="w-28 h-16 object-cover rounded border"
                                    alt="cover"
                                >
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="font-medium">{{ $wisata->nama }}</div>
                            <div class="text-gray-500">{{ $wisata->slug }}</div>
                        </td>
                        <td class="p-3">{{ $wisata->rating ?? '-' }}</td>
                        <td class="p-3">{{ $wisata->updated_at?->format('d M Y H:i') }}</td>
                        <td class="p-3 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.wisata.edit', $wisata) }}" class="px-3 py-1 rounded border">
                                    Edit
                                </a>

                                <form action="{{ route('admin.wisata.destroy', $wisata) }}" method="POST"
                                      onsubmit="return confirm('Hapus wisata ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 rounded border text-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td class="p-6 text-center text-gray-500" colspan="5">
                            Belum ada data wisata.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $wisatas->links() ?? '' }}
        </div>
    </div>

</div>
@endsection
