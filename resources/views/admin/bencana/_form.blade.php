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

    {{-- Riwayat Kejadian --}}
    @php
        $blankKejadian = [
            'judul' => '', 'tanggal_kejadian' => '', 'lokasi' => '', 'uraian' => '',
            'korban_meninggal' => '', 'korban_luka' => '', 'warga_mengungsi' => '', 'rumah_rusak' => '',
            'kerugian' => '', 'sumber' => '',
        ];

        if (old('kejadian') !== null) {
            $kejadianAwal = collect(old('kejadian'))
                ->map(fn ($row) => array_merge($blankKejadian, array_map(fn ($v) => $v ?? '', (array) $row)))
                ->values()
                ->all();
        } elseif ($isEdit) {
            $kejadianAwal = $bencana->kejadians
                ->map(fn ($k) => [
                    'judul' => $k->judul,
                    'tanggal_kejadian' => $k->tanggal_kejadian?->format('Y-m-d') ?? '',
                    'lokasi' => $k->lokasi ?? '',
                    'uraian' => $k->uraian ?? '',
                    'korban_meninggal' => $k->korban_meninggal ?? '',
                    'korban_luka' => $k->korban_luka ?? '',
                    'warga_mengungsi' => $k->warga_mengungsi ?? '',
                    'rumah_rusak' => $k->rumah_rusak ?? '',
                    'kerugian' => $k->kerugian ?? '',
                    'sumber' => $k->sumber ?? '',
                ])
                ->values()
                ->all();
        } else {
            $kejadianAwal = [];
        }

        $kejadianErrors = collect($errors->getMessages())
            ->filter(fn ($messages, $key) => str_starts_with($key, 'kejadian'))
            ->flatten()
            ->unique()
            ->values();

        $inputClass = 'w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700';
        $labelClass = 'mb-1.5 block text-sm font-medium text-neutral-700';
    @endphp

    <div
        x-data="{
            items: @js($kejadianAwal).map((row, i) => ({ ...row, key: 'k' + i })),
            seq: {{ count($kejadianAwal) }},
            today: @js(now()->toDateString()),
            add() {
                this.items.unshift({ ...@js($blankKejadian), key: 'n' + (this.seq++) });
            },
            remove(index) {
                this.items.splice(index, 1);
            },
        }"
    >
        <div class="flex items-center justify-between gap-3">
            <div>
                <h2 class="text-sm font-semibold text-neutral-900">Riwayat Kejadian</h2>
                <p class="text-xs text-neutral-500">Catat kejadian bencana yang pernah terjadi. Kejadian terbaru tampil paling atas.</p>
            </div>
            <button
                type="button"
                @click="add()"
                class="inline-flex shrink-0 items-center rounded-lg border border-emerald-800 px-3 py-1.5 text-sm font-medium text-emerald-800 transition hover:bg-emerald-50"
            >
                + Tambah kejadian
            </button>
        </div>

        @if($kejadianErrors->isNotEmpty())
            <div class="mt-3 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc space-y-0.5 pl-5">
                    @foreach($kejadianErrors as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <p x-show="items.length === 0" class="mt-3 rounded-lg border border-dashed border-neutral-300 p-4 text-center text-sm text-neutral-500">
            Belum ada riwayat kejadian.
        </p>

        <div class="mt-3 space-y-4">
            <template x-for="(item, index) in items" :key="item.key">
                <div class="rounded-xl border border-neutral-200 bg-neutral-50 p-4">
                    <div class="mb-3 flex items-center justify-between">
                        <span class="text-sm font-medium text-neutral-700" x-text="'Kejadian ' + (index + 1)"></span>
                        <button
                            type="button"
                            @click="remove(index)"
                            class="text-sm font-medium text-red-600 hover:underline"
                        >
                            Hapus
                        </button>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="{{ $labelClass }}">Judul <span class="text-red-600">*</span></label>
                            <input type="text" maxlength="150" required class="{{ $inputClass }}"
                                   :name="`kejadian[${index}][judul]`" x-model="item.judul">
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Tanggal kejadian <span class="text-red-600">*</span></label>
                            <input type="date" required class="{{ $inputClass }}"
                                   :max="today" :name="`kejadian[${index}][tanggal_kejadian]`" x-model="item.tanggal_kejadian">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="{{ $labelClass }}">Lokasi</label>
                        <input type="text" maxlength="255" class="{{ $inputClass }}"
                               :name="`kejadian[${index}][lokasi]`" x-model="item.lokasi">
                    </div>

                    <div class="mt-4">
                        <label class="{{ $labelClass }}">Uraian</label>
                        <textarea rows="3" maxlength="5000" class="{{ $inputClass }}"
                                  :name="`kejadian[${index}][uraian]`" x-model="item.uraian"></textarea>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4 md:grid-cols-4">
                        <div>
                            <label class="{{ $labelClass }}">Meninggal (jiwa)</label>
                            <input type="number" min="0" step="1" class="{{ $inputClass }}"
                                   :name="`kejadian[${index}][korban_meninggal]`" x-model="item.korban_meninggal">
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Luka-luka (jiwa)</label>
                            <input type="number" min="0" step="1" class="{{ $inputClass }}"
                                   :name="`kejadian[${index}][korban_luka]`" x-model="item.korban_luka">
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Mengungsi (jiwa)</label>
                            <input type="number" min="0" step="1" class="{{ $inputClass }}"
                                   :name="`kejadian[${index}][warga_mengungsi]`" x-model="item.warga_mengungsi">
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Rumah rusak (unit)</label>
                            <input type="number" min="0" step="1" class="{{ $inputClass }}"
                                   :name="`kejadian[${index}][rumah_rusak]`" x-model="item.rumah_rusak">
                        </div>
                    </div>

                    <div class="mt-4 grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="{{ $labelClass }}">Kerugian</label>
                            <input type="text" maxlength="100" placeholder="Contoh: Rp 50 juta" class="{{ $inputClass }}"
                                   :name="`kejadian[${index}][kerugian]`" x-model="item.kerugian">
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Sumber</label>
                            <input type="text" maxlength="150" placeholder="Contoh: BPBD Kabupaten Banyuwangi" class="{{ $inputClass }}"
                                   :name="`kejadian[${index}][sumber]`" x-model="item.sumber">
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

</div>
