@extends('layouts.admin')

@section('page_title', 'UMKM')
@section('page_subtitle', 'Kelola data usaha mikro kecil menengah')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- HEADER + FILTER --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">

            <h1 class="text-xl font-semibold text-neutral-900">Data UMKM</h1>

            {{-- FILTER KATEGORI --}}
            <form method="GET" action="{{ route('admin.umkm.index') }}">
                <select name="kategori"
                        onchange="this.form.submit()"
                        class="rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700">

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
                   class="text-sm font-medium text-neutral-500 hover:text-emerald-800 hover:underline">
                    Reset
                </a>
            @endif

        </div>

        <a href="{{ route('admin.umkm.create') }}"
           class="inline-flex items-center rounded-lg bg-emerald-800 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-900">
            + Tambah UMKM
        </a>
    </div>

    {{-- TABLE --}}
    <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-neutral-50 text-xs font-semibold uppercase tracking-wide text-neutral-500">
                <tr>
                    <th class="px-4 py-3 text-left">Cover</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Rating</th>
                    <th class="px-4 py-3 text-left">Updated</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($umkms as $umkm)
                    <tr class="border-t border-neutral-100 hover:bg-neutral-50/60">
                        <td class="px-4 py-3">
                            @if($umkm->cover_foto)
                                <img src="{{ asset('storage/' . $umkm->cover_foto) }}"
                                     class="h-16 w-28 rounded-lg border border-neutral-200 object-cover" alt="cover">
                            @else
                                <span class="text-neutral-400">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $umkm->nama }}</div>
                            <div class="text-neutral-400">{{ $umkm->slug }}</div>
                        </td>

                        <td class="px-4 py-3">
                            {{ $umkm->kategori?->nama ?? '-' }}
                        </td>

                        <td class="px-4 py-3">{{ $umkm->rating ?? '-' }}</td>

                        <td class="px-4 py-3">
                            {{ $umkm->updated_at?->format('d M Y H:i') }}
                        </td>

                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.umkm.edit', $umkm) }}"
                                   class="rounded-lg border border-neutral-300 px-3 py-1.5 text-sm font-medium text-neutral-700 transition hover:bg-neutral-50">
                                   Edit
                                </a>

                                <form action="{{ route('admin.umkm.destroy', $umkm) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus UMKM ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-red-200 px-3 py-1.5 text-sm font-medium text-red-600 transition hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t border-neutral-100 hover:bg-neutral-50/60">
                        <td class="p-6 text-center text-neutral-400" colspan="6">
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
