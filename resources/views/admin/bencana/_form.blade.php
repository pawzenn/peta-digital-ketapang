@php
    /** @var \App\Models\Bencana|null $bencana */
    $isEdit = isset($bencana) && $bencana?->exists;

    $jenisOptions = [
        'banjir' => 'Banjir',
        'longsor' => 'Longsor',
        'kebakaran' => 'Kebakaran',
        'gempa_bumi' => 'Gempa Bumi',
        'angin_puting_beliung' => 'Angin Puting Beliung',
        'lainnya' => 'Lainnya',
    ];

    $risikoOptions = [
        'rendah' => 'Rendah',
        'sedang' => 'Sedang',
        'tinggi' => 'Tinggi',
    ];
@endphp

<div class="space-y-6">

    {{-- Nama --}}
    <div>
        <label class="block text-sm font-medium mb-1">Nama / Judul</label>
        <input
            type="text"
            name="nama"
            value="{{ old('nama', $bencana->nama ?? '') }}"
            class="w-full rounded border px-3 py-2"
            required
        >
        @error('nama')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Jenis & Tingkat Risiko --}}
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium mb-1">Jenis Bencana</label>
            <select name="jenis_bencana" class="w-full rounded border px-3 py-2" required>
                <option value="">- Pilih Jenis -</option>
                @foreach($jenisOptions as $value => $label)
                    <option value="{{ $value }}" @selected(old('jenis_bencana', $bencana->jenis_bencana ?? '') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('jenis_bencana')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Tingkat Risiko</label>
            <select name="tingkat_risiko" class="w-full rounded border px-3 py-2" required>
                <option value="">- Pilih Tingkat -</option>
                @foreach($risikoOptions as $value => $label)
                    <option value="{{ $value }}" @selected(old('tingkat_risiko', $bencana->tingkat_risiko ?? '') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('tingkat_risiko')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Deskripsi --}}
    <div>
        <label class="block text-sm font-medium mb-1">Deskripsi / Info Mitigasi</label>
        <textarea
            name="deskripsi"
            rows="5"
            class="w-full rounded border px-3 py-2"
            required
        >{{ old('deskripsi', $bencana->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Alamat / Lokasi --}}
    <div>
        <label class="block text-sm font-medium mb-1">Lokasi Rawan</label>
        <input
            type="text"
            name="alamat"
            value="{{ old('alamat', $bencana->alamat ?? '') }}"
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
            value="{{ old('maps_link', $bencana->maps_link ?? '') }}"
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

        @if($isEdit && $bencana->cover_foto)
            <div class="mt-3">
                <p class="text-sm text-gray-600 mb-2">Cover saat ini:</p>
                <img
                    src="{{ asset('storage/' . $bencana->cover_foto) }}"
                    alt="Cover {{ $bencana->nama }}"
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

        @if($isEdit && $bencana->relationLoaded('galleries') && $bencana->galleries->count())
            <div class="mt-3">
                <p class="text-sm text-gray-600 mb-2">Gallery saat ini:</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($bencana->galleries as $foto)
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
