@php
    /** @var \App\Models\Wisata|null $wisata */
    $isEdit = isset($wisata) && $wisata?->exists;
@endphp

<div class="space-y-6">

    {{-- Nama --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-neutral-700">Nama</label>
        <input
            type="text"
            name="nama"
            value="{{ old('nama', $wisata->nama ?? '') }}"
            class="w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
            required
        >
        @error('nama')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Deskripsi --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-neutral-700">Deskripsi</label>
        <textarea
            name="deskripsi"
            rows="5"
            class="w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
            required
        >{{ old('deskripsi', $wisata->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Rating --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-neutral-700">Rating (1 - 5)</label>
        <input
            type="number"
            name="rating"
            step="0.1"
            min="1"
            max="5"
            inputmode="decimal"
            value="{{ old('rating', $wisata->rating ?? '') }}"
            class="w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
            placeholder="contoh: 4.5"
        >
        <p class="text-xs text-gray-500 mt-1">Boleh desimal, contoh: 4.5 atau 4,5</p>

        @error('rating')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Alamat --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-neutral-700">Alamat / Nama Jalan</label>
        <input
            type="text"
            name="alamat"
            value="{{ old('alamat', $wisata->alamat ?? '') }}"
            class="w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
        >
        @error('alamat')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Maps Link --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-neutral-700">Link Maps</label>
        <input
            type="url"
            name="maps_link"
            value="{{ old('maps_link', $wisata->maps_link ?? '') }}"
            class="w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
            placeholder="https://maps.google.com/..."
        >
        @error('maps_link')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Cover --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-neutral-700">
            Cover Foto (JPG/JPEG)
            @if(!$isEdit) <span class="text-red-600">*</span> @endif
        </label>

        <input
            type="file"
            name="cover"
            accept=".jpg,.jpeg"
            class="w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
            @if(!$isEdit) required @endif
        >

        @error('cover')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror

        @if($isEdit && $wisata->cover_foto)
            <div class="mt-3">
                <p class="mb-2 text-sm text-neutral-500">Cover saat ini:</p>
                <img
                    src="{{ asset('storage/' . $wisata->cover_foto) }}"
                    alt="Cover {{ $wisata->nama }}"
                    class="h-48 w-full max-w-md rounded-lg border border-neutral-200 object-cover"
                >
            </div>
        @endif
    </div>

    {{-- Foto Rute --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-neutral-700">Foto Rute (untuk section "Rute" di halaman detail)</label>
        <input
            type="file"
            name="foto_rute"
            accept=".jpg,.jpeg"
            class="w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
        >
        @error('foto_rute')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror

        @if($isEdit && $wisata->foto_rute)
            <div class="mt-3">
                <p class="mb-2 text-sm text-neutral-500">Foto rute saat ini:</p>
                <img
                    src="{{ asset('storage/' . $wisata->foto_rute) }}"
                    alt="Rute {{ $wisata->nama }}"
                    class="h-48 w-full max-w-md rounded-lg border border-neutral-200 object-cover"
                >
            </div>
        @endif
    </div>

    {{-- Gallery --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-neutral-700">Gallery (boleh banyak, JPG/JPEG)</label>
        <input
            type="file"
            name="gallery[]"
            accept=".jpg,.jpeg"
            multiple
            class="w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
        >

        @error('gallery')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @error('gallery.*')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror

        @if($isEdit && $wisata->relationLoaded('galleries') && $wisata->galleries->count())
            <div class="mt-3">
                <p class="mb-2 text-sm text-neutral-500">Gallery saat ini:</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($wisata->galleries as $foto)
                        <div class="overflow-hidden rounded-lg border border-neutral-200">
                            <img
                                src="{{ asset('storage/' . $foto->file_path) }}"
                                class="w-full h-28 object-cover"
                                alt="Gallery"
                            >
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</div>
