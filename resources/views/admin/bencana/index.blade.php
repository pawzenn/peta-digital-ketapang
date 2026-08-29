@extends('layouts.admin')

@section('page_title', 'Bencana')
@section('page_subtitle', 'Kelola data wilayah rawan bencana')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-neutral-900">Peta Bencana</h2>
                <p class="mt-0.5 text-sm text-neutral-500">Ditampilkan di section "Peta Bencana" pada halaman utama.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.bencana.peta-bencana.update') }}" enctype="multipart/form-data" class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-start">
            @csrf
            @method('PUT')

            @if($profil?->peta_bencana)
                <img src="{{ asset('storage/'.$profil->peta_bencana) }}"
                     class="h-32 w-full rounded-lg border border-neutral-200 object-cover sm:w-56">
            @else
                <div class="flex h-32 w-full items-center justify-center rounded-lg border border-dashed border-neutral-300 text-sm text-neutral-400 sm:w-56">
                    Belum ada peta
                </div>
            @endif

            <div class="flex-1 space-y-2">
                <input type="file" name="peta_bencana" accept=".jpg,.jpeg"
                       class="block w-full text-sm text-neutral-600 file:mr-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-emerald-800 hover:file:bg-emerald-100">
                @error('peta_bencana')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
                <button class="inline-flex items-center rounded-lg bg-emerald-800 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-900">
                    Simpan Peta
                </button>
            </div>
        </form>
    </div>

    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold text-neutral-900">Data Bencana</h1>
        <a href="{{ route('admin.bencana.create') }}" class="inline-flex items-center rounded-lg bg-emerald-800 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-900">
            + Tambah Data Bencana
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm">
        <table class="w-full text-sm">
            <thead class="bg-neutral-50 text-xs font-semibold uppercase tracking-wide text-neutral-500">
                <tr>
                    <th class="px-4 py-3 text-left">Cover</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Jenis</th>
                    <th class="px-4 py-3 text-left">Risiko</th>
                    <th class="px-4 py-3 text-left">Updated</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bencanas as $bencana)
                    <tr class="border-t border-neutral-100 hover:bg-neutral-50/60">
                        <td class="px-4 py-3">
                            @if($bencana->cover_foto)
                                <img
                                    src="{{ asset('storage/' . $bencana->cover_foto) }}"
                                    class="h-16 w-28 rounded-lg border border-neutral-200 object-cover"
                                    alt="cover"
                                >
                            @else
                                <span class="text-neutral-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $bencana->nama }}</div>
                            <div class="text-neutral-400">{{ $bencana->slug }}</div>
                        </td>
                        <td class="px-4 py-3">{{ str($bencana->jenis_bencana)->replace('_', ' ')->title() }}</td>
                        <td class="px-4 py-3">{{ str($bencana->tingkat_risiko)->title() }}</td>
                        <td class="px-4 py-3">{{ $bencana->updated_at?->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex gap-2">
                                <a href="{{ route('admin.bencana.edit', $bencana) }}" class="rounded-lg border border-neutral-300 px-3 py-1.5 text-sm font-medium text-neutral-700 transition hover:bg-neutral-50">
                                    Edit
                                </a>

                                <form action="{{ route('admin.bencana.destroy', $bencana) }}" method="POST"
                                      onsubmit="return confirm('Hapus data bencana ini?')">
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
                        <td class="p-6 text-center text-neutral-400" colspan="6">
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
