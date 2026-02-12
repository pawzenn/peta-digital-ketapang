@php
    /** @var \App\Models\Umkm|null $umkm */
    $isEdit = isset($umkm) && $umkm?->exists;
@endphp

<div class="space-y-6">

    {{-- Kategori --}}
    <div>
        <label class="block text-sm font-medium mb-1">Kategori UMKM</label>
        <select name="kategori_umkm_id" class="w-full rounded border px-3 py-2" required>
            <option value="">-- pilih kategori --</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->id }}"
                    @selected(old('kategori_umkm_id', $umkm->kategori_umkm_id ?? '') == $kat->id)>
                    {{ $kat->nama }}
                </option>
            @endforeach
        </select>
        @error('kategori_umkm_id')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nama --}}
    <div>
        <label class="block text-sm font-medium mb-1">Nama</label>
        <input type="text" name="nama"
               value="{{ old('nama', $umkm->nama ?? '') }}"
               class="w-full rounded border px-3 py-2" required>
        @error('nama')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Deskripsi --}}
    <div>
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="5"
                  class="w-full rounded border px-3 py-2" required>{{ old('deskripsi', $umkm->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Rating --}}
    <div>
        <label class="block text-sm font-medium mb-1">Rating (1-5)</label>
        <input type="number" name="rating" step="0.1" min="1" max="5"
               value="{{ old('rating', $umkm->rating ?? '') }}"
               class="w-full rounded border px-3 py-2">
        @error('rating')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Alamat --}}
    <div>
        <label class="block text-sm font-medium mb-1">Alamat / Nama Jalan</label>
        <input type="text" name="alamat"
               value="{{ old('alamat', $umkm->alamat ?? '') }}"
               class="w-full rounded border px-3 py-2">
        @error('alamat')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Maps Link --}}
    <div>
        <label class="block text-sm font-medium mb-1">Link Maps</label>
        <input type="url" name="maps_link"
               value="{{ old('maps_link', $umkm->maps_link ?? '') }}"
               class="w-full rounded border px-3 py-2"
               placeholder="https://maps.google.com/...">
        @error('maps_link')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Cover --}}
    <div>
        <label class="block text-sm font-medium mb-1">
            Cover Foto (JPG/JPEG) @if(!$isEdit) <span class="text-red-600">*</span> @endif
        </label>
        <input type="file" name="cover" accept=".jpg,.jpeg"
               class="w-full rounded border px-3 py-2"
               @if(!$isEdit) required @endif>

        @error('cover')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror

        @if($isEdit && $umkm->cover_foto)
            <div class="mt-3">
                <p class="text-sm text-gray-600 mb-2">Cover saat ini:</p>
                <img src="{{ asset('storage/' . $umkm->cover_foto) }}"
                     class="w-full max-w-md h-48 object-cover rounded border" alt="cover">
            </div>
        @endif
    </div>

    {{-- Gallery --}}
    <div>
        <label class="block text-sm font-medium mb-1">Gallery (boleh banyak, JPG/JPEG)</label>
        <input type="file" name="gallery[]" accept=".jpg,.jpeg" multiple
               class="w-full rounded border px-3 py-2">

        @error('gallery')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
        @error('gallery.*')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror

        @if($isEdit && $umkm->relationLoaded('galleries') && $umkm->galleries->count())
            <div class="mt-3">
                <p class="text-sm text-gray-600 mb-2">Gallery saat ini:</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($umkm->galleries as $foto)
                        <div class="border rounded overflow-hidden">
                            <img src="{{ asset('storage/' . $foto->file_path) }}"
                                 class="w-full h-28 object-cover" alt="gallery">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</div>
