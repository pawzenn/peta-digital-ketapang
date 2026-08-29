@extends('layouts.admin')

@section('title', 'Homestay - Admin')

@section('page_title', 'Data Homestay')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-neutral-900">Data Homestay</h1>
        <a href="{{ route('admin.homestay.create') }}" class="inline-flex items-center rounded-lg bg-emerald-800 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-900">
            + Tambah Homestay
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-neutral-50 text-xs font-semibold uppercase tracking-wide text-neutral-500">
                <tr>
                    <th class="px-4 py-3 text-left">Cover</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Rating</th>
                    <th class="px-4 py-3 text-left">Updated</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($homestays as $homestay)
                    <tr class="border-t border-neutral-100 hover:bg-neutral-50/60">
                        <td class="px-4 py-3">
                            @if($homestay->cover_foto)
                                <img
                                    src="{{ asset('storage/' . $homestay->cover_foto) }}"
                                    class="h-16 w-28 rounded-lg border border-neutral-200 object-cover"
                                    alt="cover"
                                >
                            @else
                                <span class="text-neutral-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $homestay->nama }}</div>
                            <div class="text-neutral-400">{{ $homestay->slug }}</div>
                        </td>
                        <td class="px-4 py-3">{{ $homestay->rating ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $homestay->updated_at?->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.homestay.edit', $homestay) }}" class="rounded-lg border border-neutral-300 px-3 py-1.5 text-sm font-medium text-neutral-700 transition hover:bg-neutral-50">
                                    Edit
                                </a>

                                <form action="{{ route('admin.homestay.destroy', $homestay) }}" method="POST"
                                      onsubmit="return confirm('Hapus homestay ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 text-sm font-medium text-red-600 transition hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t border-neutral-100 hover:bg-neutral-50/60">
                        <td class="p-6 text-center text-neutral-400" colspan="5">
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
