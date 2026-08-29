@php
    /** @var \App\Models\Bencana|null $bencana */
    $isEdit = isset($bencana) && $bencana?->exists;

    $jenisOptions = [
        'banjir' => 'Banjir',
        'banjir_bandang' => 'Banjir Bandang',
        'tanah_longsor' => 'Tanah Longsor',
        'cuaca_ekstrem' => 'Cuaca Ekstrem',
        'gelombang_ekstrem_abrasi' => 'Gelombang Ekstrem & Abrasi',
        'gempa_bumi' => 'Gempa Bumi',
        'kegagalan_teknologi' => 'Kegagalan Teknologi',
        'likuifaksi' => 'Likuifaksi',
        'kebakaran' => 'Kebakaran',
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
        <label class="mb-1.5 block text-sm font-medium text-neutral-700">Nama / Judul</label>
        <input
            type="text"
            name="nama"
            value="{{ old('nama', $bencana->nama ?? '') }}"
            class="w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
            required
        >
        @error('nama')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Jenis & Tingkat Risiko --}}
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="mb-1.5 block text-sm font-medium text-neutral-700">Jenis Bencana</label>
            <select name="jenis_bencana" class="w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700" required>
                <option value="">- Pilih Jenis -</option>
                @foreach($jenisOptions as $value => $label)
                    <option value="{{ $value }}" @selected(old('jenis_bencana', $bencana->jenis_bencana ?? '') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('jenis_bencana')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-neutral-700">Tingkat Risiko</label>
            <select name="tingkat_risiko" class="w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700" required>
                <option value="">- Pilih Tingkat -</option>
                @foreach($risikoOptions as $value => $label)
                    <option value="{{ $value }}" @selected(old('tingkat_risiko', $bencana->tingkat_risiko ?? '') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('tingkat_risiko')
                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Deskripsi --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-neutral-700">Deskripsi / Info Mitigasi</label>
        <textarea
            name="deskripsi"
            rows="5"
            class="w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700"
            required
        >{{ old('deskripsi', $bencana->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Alamat / Lokasi --}}
    <div>
        <label class="mb-1.5 block text-sm font-medium text-neutral-700">Lokasi Rawan</label>
        <input
            type="text"
            name="alamat"
            value="{{ old('alamat', $bencana->alamat ?? '') }}"
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
            value="{{ old('maps_link', $bencana->maps_link ?? '') }}"
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

        @if($isEdit && $bencana->cover_foto)
            <div class="mt-3">
                <p class="mb-2 text-sm text-neutral-500">Cover saat ini:</p>
                <img
                    src="{{ asset('storage/' . $bencana->cover_foto) }}"
                    alt="Cover {{ $bencana->nama }}"
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

        @if($isEdit && $bencana->relationLoaded('galleries') && $bencana->galleries->count())
            <div class="mt-3">
                <p class="mb-2 text-sm text-neutral-500">Gallery saat ini:</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($bencana->galleries as $foto)
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
