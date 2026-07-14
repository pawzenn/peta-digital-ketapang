@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold">Data Bencana</h1>
        <a href="{{ route('admin.bencana.create') }}" class="px-4 py-2 rounded bg-black text-white">
            + Tambah Data Bencana
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
                    <th class="text-left p-3">Jenis</th>
                    <th class="text-left p-3">Risiko</th>
                    <th class="text-left p-3">Updated</th>
                    <th class="text-right p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bencanas as $bencana)
                    <tr class="border-t">
                        <td class="p-3">
                            @if($bencana->cover_foto)
                                <img
                                    src="{{ asset('storage/' . $bencana->cover_foto) }}"
                                    class="w-28 h-16 object-cover rounded border"
                                    alt="cover"
                                >
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="font-medium">{{ $bencana->nama }}</div>
                            <div class="text-gray-500">{{ $bencana->slug }}</div>
                        </td>
                        <td class="p-3">{{ str($bencana->jenis_bencana)->replace('_', ' ')->title() }}</td>
                        <td class="p-3">{{ str($bencana->tingkat_risiko)->title() }}</td>
                        <td class="p-3">{{ $bencana->updated_at?->format('d M Y H:i') }}</td>
                        <td class="p-3 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.bencana.edit', $bencana) }}" class="px-3 py-1 rounded border">
                                    Edit
                                </a>

                                <form action="{{ route('admin.bencana.destroy', $bencana) }}" method="POST"
                                      onsubmit="return confirm('Hapus data bencana ini?')">
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
                        <td class="p-6 text-center text-gray-500" colspan="6">
                            Belum ada data bencana.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $bencanas->links() ?? '' }}
        </div>
    </div>

</div>
@endsection
