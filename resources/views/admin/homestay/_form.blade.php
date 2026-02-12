@php
    /** @var \App\Models\Homestay|null $homestay */
    $isEdit = isset($homestay) && $homestay?->exists;
@endphp

<div class="space-y-6">

    {{-- Nama --}}
    <div>
        <label class="block text-sm font-medium mb-1">Nama</label>
        <input
            type="text"
            name="nama"
            value="{{ old('nama', $homestay->nama ?? '') }}"
            class="w-full rounded border px-3 py-2"
            required
        >
        @error('nama')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Deskripsi --}}
    <div>
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea
            name="deskripsi"
            rows="5"
            class="w-full rounded border px-3 py-2"
            required
        >{{ old('deskripsi', $homestay->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Rating --}}
    <div>
        <label class="block text-sm font-medium mb-1">Rating (1 - 5)</label>
        <input
            type="number"
            name="rating"
            step="0.1"
            min="1"
            max="5"
            inputmode="decimal"
            value="{{ old('rating', $homestay->rating ?? '') }}"
            class="w-full rounded border px-3 py-2"
            placeholder="contoh: 4.5"
        >
        <p class="text-xs text-gray-500 mt-1">Boleh desimal, contoh: 4.5 atau 4,5</p>

        @error('rating')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Alamat --}}
    <div>
        <label class="block text-sm font-medium mb-1">Alamat / Nama Jalan</label>
        <input
            type="text"
            name="alamat"
            value="{{ old('alamat', $homestay->alamat ?? '') }}"
            class="w-full rounded border px-3 py-2"
        >
        @error('alamat')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Maps Link --}}
    <div>
        <label class="block text-sm font-medium mb-1">Link Maps</label>
        <input
            type="url"
            name="maps_link"
            value="{{ old('maps_link', $homestay->maps_link ?? '') }}"
            class="w-full rounded border px-3 py-2"
            placeholder="https://maps.google.com/..."
        >
        @error('maps_link')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Cover --}}
    <div>
        <label class="block text-sm font-medium mb-1">
            Cover Foto (JPG/JPEG)
            @if(!$isEdit) <span class="text-red-600">*</span> @endif
        </label>

        <input
            type="file"
            name="cover"
            accept=".jpg,.jpeg"
            class="w-full rounded border px-3 py-2"
            @if(!$isEdit) required @endif
        >

        @error('cover')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror

        @if($isEdit && $homestay->cover_foto)
            <div class="mt-3">
                <p class="text-sm text-gray-600 mb-2">Cover saat ini:</p>
                <img
                    src="{{ asset('storage/' . $homestay->cover_foto) }}"
                    alt="Cover {{ $homestay->nama }}"
                    class="w-full max-w-md h-48 object-cover rounded border"
                >
            </div>
        @endif
    </div>

    {{-- Gallery --}}
    <div>
        <label class="block text-sm font-medium mb-1">Gallery (boleh banyak, JPG/JPEG)</label>
        <input
            type="file"
            name="gallery[]"
            accept=".jpg,.jpeg"
            multiple
            class="w-full rounded border px-3 py-2"
        >

        @error('gallery')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
        @error('gallery.*')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror

        @if($isEdit && $homestay->relationLoaded('galleries') && $homestay->galleries->count())
            <div class="mt-3">
                <p class="text-sm text-gray-600 mb-2">Gallery saat ini:</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($homestay->galleries as $foto)
                        <div class="border rounded overflow-hidden">
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
