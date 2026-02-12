@extends('layouts.admin')

@section('title', 'Homestay - Admin')

@section('page_title', 'Data Homestay')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold">Data Homestay</h1>
        <a href="{{ route('admin.homestay.create') }}" class="px-4 py-2 rounded bg-black text-white">
            + Tambah Homestay
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
                @forelse($homestays as $homestay)
                    <tr class="border-t">
                        <td class="p-3">
                            @if($homestay->cover_foto)
                                <img
                                    src="{{ asset('storage/' . $homestay->cover_foto) }}"
                                    class="w-28 h-16 object-cover rounded border"
                                    alt="cover"
                                >
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="font-medium">{{ $homestay->nama }}</div>
                            <div class="text-gray-500">{{ $homestay->slug }}</div>
                        </td>
                        <td class="p-3">{{ $homestay->rating ?? '-' }}</td>
                        <td class="p-3">{{ $homestay->updated_at?->format('d M Y H:i') }}</td>
                        <td class="p-3 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.homestay.edit', $homestay) }}" class="px-3 py-1 rounded border">
                                    Edit
                                </a>

                                <form action="{{ route('admin.homestay.destroy', $homestay) }}" method="POST"
                                      onsubmit="return confirm('Hapus homestay ini?')">
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
                            Belum ada data homestay.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $homestays->links() ?? '' }}
        </div>
    </div>

</div>
@endsection
