{{-- Video rute, video review TikTok, dan penghargaan. Dipakai form Wisata, Homestay, dan UMKM. --}}
@php
    /** @var \Illuminate\Database\Eloquent\Model|null $model */
    $model = $model ?? null;
    $isEdit = $model?->exists;

    $videoAwal = old('video_reviews') !== null
        ? collect(old('video_reviews'))->map(fn ($r) => [
            'url' => $r['url'] ?? '',
            'caption' => $r['caption'] ?? '',
        ])->values()->all()
        : ($isEdit
            ? $model->videoReviews->map(fn ($v) => ['url' => $v->url, 'caption' => $v->caption ?? ''])->values()->all()
            : []);

    $awardAwal = old('penghargaan') !== null
        ? collect(old('penghargaan'))->map(fn ($r) => [
            'nama' => $r['nama'] ?? '',
            'tahun' => $r['tahun'] ?? '',
            'pemberi' => $r['pemberi'] ?? '',
        ])->values()->all()
        : ($isEdit
            ? $model->penghargaans->map(fn ($p) => [
                'nama' => $p->nama,
                'tahun' => $p->tahun ?? '',
                'pemberi' => $p->pemberi ?? '',
            ])->values()->all()
            : []);

    $extraErrors = collect($errors->getMessages())
        ->filter(fn ($messages, $key) => str_starts_with($key, 'video_reviews') || str_starts_with($key, 'penghargaan'))
        ->flatten()
        ->unique()
        ->values();

    $inputClass = 'w-full rounded-lg border-neutral-300 text-sm shadow-sm focus:border-emerald-700 focus:ring-emerald-700';
    $labelClass = 'mb-1.5 block text-sm font-medium text-neutral-700';
@endphp

<div class="space-y-6 border-t border-neutral-200 pt-6">

    <div>
        <h2 class="text-base font-semibold text-neutral-900">Video &amp; Penghargaan</h2>
        <p class="text-xs text-neutral-500">Opsional. Ditampilkan di halaman detail sebagai video TikTok dan badge penghargaan.</p>
    </div>

    @if($extraErrors->isNotEmpty())
        <div class="rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
            <ul class="list-disc space-y-0.5 pl-5">
                @foreach($extraErrors as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Video rute --}}
    <div>
        <label class="{{ $labelClass }}">Link Video Rute (TikTok)</label>
        <input
            type="url"
            name="video_rute_link"
            value="{{ old('video_rute_link', $model->video_rute_link ?? '') }}"
            class="{{ $inputClass }}"
            placeholder="https://www.tiktok.com/@akun/video/123... atau https://vt.tiktok.com/..."
        >
        <p class="mt-1 text-xs text-neutral-500">Tombol "Lihat Rute (Video)" muncul di halaman detail kalau diisi.</p>
        @error('video_rute_link')
            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Video review --}}
    <div
        x-data="{
            items: @js($videoAwal).map((row, i) => ({ ...row, key: 'v' + i })),
            seq: {{ count($videoAwal) }},
            add() { this.items.push({ url: '', caption: '', key: 'n' + (this.seq++) }); },
            remove(i) { this.items.splice(i, 1); },
            move(i, d) {
                const j = i + d;
                if (j < 0 || j >= this.items.length) return;
                [this.items[i], this.items[j]] = [this.items[j], this.items[i]];
            },
        }"
    >
        <div class="flex items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-semibold text-neutral-900">Video Review (TikTok)</h3>
                <p class="text-xs text-neutral-500">Urutan baris = urutan tampil di halaman publik.</p>
            </div>
            <button type="button" @click="add()"
                    class="inline-flex shrink-0 items-center rounded-lg border border-emerald-800 px-3 py-1.5 text-sm font-medium text-emerald-800 transition hover:bg-emerald-50">
                + Tambah video
            </button>
        </div>

        <p x-show="items.length === 0" class="mt-3 rounded-lg border border-dashed border-neutral-300 p-4 text-center text-sm text-neutral-500">
            Belum ada video review.
        </p>

        <div class="mt-3 space-y-3">
            <template x-for="(item, index) in items" :key="item.key">
                <div class="rounded-xl border border-neutral-200 bg-neutral-50 p-4">
                    <div class="mb-3 flex items-center justify-between">
                        <span class="text-sm font-medium text-neutral-700" x-text="'Video ' + (index + 1)"></span>
                        <div class="flex items-center gap-3 text-sm">
                            <button type="button" @click="move(index, -1)" :disabled="index === 0" class="text-neutral-500 hover:text-emerald-800 disabled:opacity-30" aria-label="Naik">&uarr;</button>
                            <button type="button" @click="move(index, 1)" :disabled="index === items.length - 1" class="text-neutral-500 hover:text-emerald-800 disabled:opacity-30" aria-label="Turun">&darr;</button>
                            <button type="button" @click="remove(index)" class="font-medium text-red-600 hover:underline">Hapus</button>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="{{ $labelClass }}">Link TikTok <span class="text-red-600">*</span></label>
                            <input type="url" required maxlength="255" class="{{ $inputClass }}"
                                   placeholder="https://www.tiktok.com/@akun/video/123..."
                                   :name="`video_reviews[${index}][url]`" x-model="item.url">
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Keterangan</label>
                            <input type="text" maxlength="150" class="{{ $inputClass }}"
                                   placeholder="Contoh: Review homestay oleh @akun"
                                   :name="`video_reviews[${index}][caption]`" x-model="item.caption">
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- Penghargaan --}}
    <div
        x-data="{
            items: @js($awardAwal).map((row, i) => ({ ...row, key: 'p' + i })),
            seq: {{ count($awardAwal) }},
            add() { this.items.push({ nama: '', tahun: '', pemberi: '', key: 'n' + (this.seq++) }); },
            remove(i) { this.items.splice(i, 1); },
            move(i, d) {
                const j = i + d;
                if (j < 0 || j >= this.items.length) return;
                [this.items[i], this.items[j]] = [this.items[j], this.items[i]];
            },
        }"
    >
        <div class="flex items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-semibold text-neutral-900">Penghargaan</h3>
                <p class="text-xs text-neutral-500">Tampil sebagai badge emas di bawah deskripsi.</p>
            </div>
            <button type="button" @click="add()"
                    class="inline-flex shrink-0 items-center rounded-lg border border-amber-600 px-3 py-1.5 text-sm font-medium text-amber-700 transition hover:bg-amber-50">
                + Tambah penghargaan
            </button>
        </div>

        <p x-show="items.length === 0" class="mt-3 rounded-lg border border-dashed border-neutral-300 p-4 text-center text-sm text-neutral-500">
            Belum ada penghargaan.
        </p>

        <div class="mt-3 space-y-3">
            <template x-for="(item, index) in items" :key="item.key">
                <div class="rounded-xl border border-amber-200 bg-amber-50/40 p-4">
                    <div class="mb-3 flex items-center justify-between">
                        <span class="text-sm font-medium text-neutral-700" x-text="'Penghargaan ' + (index + 1)"></span>
                        <div class="flex items-center gap-3 text-sm">
                            <button type="button" @click="move(index, -1)" :disabled="index === 0" class="text-neutral-500 hover:text-emerald-800 disabled:opacity-30" aria-label="Naik">&uarr;</button>
                            <button type="button" @click="move(index, 1)" :disabled="index === items.length - 1" class="text-neutral-500 hover:text-emerald-800 disabled:opacity-30" aria-label="Turun">&darr;</button>
                            <button type="button" @click="remove(index)" class="font-medium text-red-600 hover:underline">Hapus</button>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-6">
                        <div class="md:col-span-3">
                            <label class="{{ $labelClass }}">Nama penghargaan <span class="text-red-600">*</span></label>
                            <input type="text" required maxlength="150" class="{{ $inputClass }}"
                                   placeholder="Contoh: Juara 1 Lomba Desa Wisata"
                                   :name="`penghargaan[${index}][nama]`" x-model="item.nama">
                        </div>
                        <div class="md:col-span-1">
                            <label class="{{ $labelClass }}">Tahun</label>
                            <input type="text" inputmode="numeric" pattern="\d{4}" maxlength="4" class="{{ $inputClass }}"
                                   placeholder="2025"
                                   :name="`penghargaan[${index}][tahun]`" x-model="item.tahun">
                        </div>
                        <div class="md:col-span-2">
                            <label class="{{ $labelClass }}">Pemberi</label>
                            <input type="text" maxlength="150" class="{{ $inputClass }}"
                                   placeholder="Contoh: Dinas Pariwisata"
                                   :name="`penghargaan[${index}][pemberi]`" x-model="item.pemberi">
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

</div>
