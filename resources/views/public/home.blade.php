@extends('layouts.public')

@section('title', 'Beranda - Peta Digital Ketapang')

@section('content')

{{-- HERO --}}
<div class="relative -mt-20 flex h-screen items-center justify-center overflow-hidden">
    <video
        src="{{ asset('images/hero-video-ketapang.mp4') }}"
        class="absolute inset-0 h-full w-full object-cover"
        autoplay
        muted
        loop
        playsinline
    ></video>

    {{-- soft glow behind navbar, for legibility over the photo --}}
    <div class="pointer-events-none absolute inset-x-0 top-0 h-64 bg-[radial-gradient(ellipse_60%_100%_at_50%_0%,rgba(255,247,239,0.8),rgba(255,247,239,0)_70%)]"></div>

    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>

    <div class="relative mt-16 flex flex-col items-center px-6 text-center">
        <h1 class="font-serif text-4xl font-bold text-white md:text-5xl">
            Selamat Datang di Peta Digital Desa Ketapang
        </h1>
        <p class="mt-4 max-w-2xl text-lg text-white/90 md:text-xl">
            Jelajahi wisata, homestay, dan UMKM Desa Ketapang, semua dalam satu peta digital.
        </p>

        <a href="#konten" class="mt-6 rounded-md bg-orange-500 px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-orange-600">
            Yuk Jelajahi
        </a>
    </div>
</div>

<div id="konten" class="mx-auto max-w-7xl scroll-mt-20 px-6 py-16">

    {{-- PROFIL --}}
    <div class="grid gap-10 md:grid-cols-[1fr_1.35fr] md:items-start">
        <div>
            <h2 class="text-2xl font-bold text-emerald-900">Profil Desa Ketapang</h2>
            <p class="mt-4 leading-relaxed text-neutral-600">
                {{ $profil->deskripsi_singkat ?? 'Website informasi desa berbasis peta untuk wisata, homestay, UMKM, dan kebencanaan.' }}
            </p>
        </div>

        @if(!empty($profil?->peta_wilayah))
            <img
                src="{{ asset('storage/' . $profil->peta_wilayah) }}"
                alt="Peta Wilayah"
                class="w-full"
            >
        @endif
    </div>

    {{-- WISATA --}}
    <div class="mt-24">
        <x-public.section-header
            eyebrow="Jelajahi Alam"
            title="Wisata Desa Ketapang"
            subtitle="Pesona alam tersembunyi yang menanti untuk dijelajahi, dari tebing eksotis hingga aliran sungai yang menyejukkan."
            href="/wisata"
            align="left"
        />

        @if($wisataTop->count())
            @php
                $wisataItems = $wisataTop->map(fn ($w) => [
                    'nama' => $w->nama,
                    'deskripsi' => $w->deskripsi,
                    'coverUrl' => $w->cover_foto ? asset('storage/'.$w->cover_foto) : null,
                    'detailUrl' => '/wisata/'.$w->slug,
                    'rating' => $w->rating,
                ])->all();
            @endphp
            <div class="mt-6">
                <x-public.carousel :items="$wisataItems" />
            </div>
        @else
            <div class="mt-6 rounded-xl border bg-white p-6 text-neutral-500">Belum ada data wisata.</div>
        @endif
    </div>

    {{-- UMKM --}}
    <div class="mt-24">
        <x-public.section-header
            eyebrow="Produk Lokal"
            title="UMKM Desa Ketapang"
            subtitle="Karya dan cita rasa autentik hasil tangan warga, diracik dengan kehangatan khas pedesaan."
            href="/umkm"
            align="left"
        />

        @if($umkmTop->count())
            @php
                $umkmItems = $umkmTop->map(fn ($u) => [
                    'nama' => $u->nama,
                    'deskripsi' => $u->deskripsi,
                    'coverUrl' => $u->cover_foto ? asset('storage/'.$u->cover_foto) : null,
                    'detailUrl' => '/umkm/'.$u->slug,
                    'rating' => $u->rating,
                    'badge' => $u->kategori?->nama,
                ])->all();
            @endphp
            <div class="mt-6">
                <x-public.carousel :items="$umkmItems" />
            </div>
        @else
            <div class="mt-6 rounded-xl border bg-white p-6 text-neutral-500">Belum ada data UMKM.</div>
        @endif
    </div>

    {{-- HOMESTAY --}}
    <div class="mt-24">
        <x-public.section-header
            eyebrow="Tempat Menginap"
            title="Homestay Desa Ketapang"
            subtitle="Hunian nyaman bernuansa alam pedesaan untuk pengalaman menginap yang berkesan."
            href="/homestay"
            align="left"
        />

        @if($homestayTop->count())
            @php
                $homestayItems = $homestayTop->map(fn ($h) => [
                    'nama' => $h->nama,
                    'deskripsi' => $h->deskripsi,
                    'coverUrl' => $h->cover_foto ? asset('storage/'.$h->cover_foto) : null,
                    'detailUrl' => '/homestay/'.$h->slug,
                    'rating' => $h->rating,
                ])->all();
            @endphp
            <div class="mt-6">
                <x-public.carousel :items="$homestayItems" />
            </div>
        @else
            <div class="mt-6 rounded-xl border bg-white p-6 text-neutral-500">Belum ada data homestay.</div>
        @endif
    </div>

    {{-- PETA BENCANA --}}
    <div id="peta-bencana" class="mt-24 scroll-mt-24">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-emerald-900">Peta Bencana</h2>
            @if($bencanas->isNotEmpty())
                <a href="/bencana" class="text-xs font-medium text-emerald-800 hover:underline sm:text-sm">Lihat Peta Lengkap &rarr;</a>
            @endif
        </div>

        @php
            $petaBencanaSlides = collect();

            foreach ($bencanas as $b) {
                if ($b->cover_foto) {
                    $petaBencanaSlides->push([
                        'label' => $b->jenis_label,
                        'nama' => $b->nama,
                        'deskripsi' => $b->deskripsi,
                        'url' => asset('storage/'.$b->cover_foto),
                        'slug' => $b->slug,
                    ]);
                }
            }

            $totalSlides = $petaBencanaSlides->count();
            $extendedSlides = $totalSlides > 1
                ? collect([$petaBencanaSlides->last()])->merge($petaBencanaSlides)->push($petaBencanaSlides->first())
                : $petaBencanaSlides;
        @endphp

        @if($totalSlides === 0)
            <div class="mt-6 rounded-xl border bg-white p-6 text-neutral-500">
                Peta bencana belum diunggah admin.
            </div>
        @else
            <p class="mt-1 text-sm leading-relaxed text-neutral-500">Kumpulan peta tingkat kerawanan bencana di Desa Ketapang berdasarkan kajian BPBD Kabupaten Banyuwangi, sebagai acuan mitigasi dan kesiapsiagaan warga.</p>

            <div class="mt-8" x-data="carousel({{ $totalSlides }}, 0)">
                @if($totalSlides > 1)
                    <div class="mb-6 hidden flex-wrap justify-center gap-2 sm:flex">
                        @foreach($petaBencanaSlides as $i => $slide)
                            <button
                                type="button"
                                @click="goTo({{ $i }})"
                                :class="realIndex() === {{ $i }} ? 'bg-emerald-900 text-white' : 'bg-white text-neutral-700 ring-1 ring-black/10 hover:bg-emerald-50'"
                                class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors"
                            >
                                {{ $slide['label'] }}
                            </button>
                        @endforeach
                    </div>
                @endif

                <div
                    class="relative overflow-hidden {{ $totalSlides > 1 ? 'cursor-grab select-none active:cursor-grabbing' : '' }}"
                    @if($totalSlides > 1)
                        @mousedown="dragStart($event)"
                        @mousemove.window="dragMove($event)"
                        @mouseup.window="dragEnd()"
                        @touchstart="dragStart($event)"
                        @touchmove="dragMove($event)"
                        @touchend="dragEnd()"
                        @click.capture="if (wasDragging) { $event.preventDefault(); $event.stopPropagation(); }"
                    @endif
                >
                    <div
                        class="flex items-center"
                        @if($totalSlides > 1)
                            :style="'transition:' + trackTransition() + '; transform: translateX(calc(-' + active + ' * 100% + ' + deltaX + 'px))'"
                        @endif
                    >
                        @foreach($extendedSlides as $slide)
                            <div class="w-full shrink-0 px-4 text-center sm:px-16">
                                <a href="/bencana/{{ $slide['slug'] }}">
                                    <img
                                        src="{{ $slide['url'] }}"
                                        alt="{{ $slide['nama'] }}"
                                        class="mx-auto max-h-[680px] w-auto max-w-full rounded-lg shadow-md transition hover:opacity-90"
                                    >
                                </a>
                            </div>
                        @endforeach
                    </div>

                    @if($totalSlides > 1)
                        <button
                            type="button"
                            @click="manualPrev()"
                            class="absolute left-1 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/80 p-2 text-neutral-800 shadow-md transition hover:bg-white sm:left-2 sm:p-3"
                            aria-label="Sebelumnya"
                        >
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12.5 15L7.5 10L12.5 5" />
                            </svg>
                        </button>

                        <button
                            type="button"
                            @click="manualNext()"
                            class="absolute right-1 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/80 p-2 text-neutral-800 shadow-md transition hover:bg-white sm:right-2 sm:p-3"
                            aria-label="Berikutnya"
                        >
                            <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M7.5 5L12.5 10L7.5 15" />
                            </svg>
                        </button>
                    @endif
                </div>

                <div class="mx-auto mt-8 max-w-2xl text-center">
                    @foreach($petaBencanaSlides as $i => $slide)
                        <div @if($totalSlides > 1) x-show="realIndex() === {{ $i }}" x-cloak @endif>
                            <h4 class="text-base font-semibold text-neutral-900">{{ $slide['nama'] }}</h4>
                            @if(!empty($slide['deskripsi']))
                                <p class="mt-2 text-sm leading-relaxed text-neutral-500">{{ $slide['deskripsi'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
