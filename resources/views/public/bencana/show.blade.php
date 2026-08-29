@extends('layouts.public')

@section('title', ($bencana->nama ?? 'Peta Bencana').' - Peta Digital Ketapang')

@section('content')
<div class="mx-auto max-w-6xl px-6 py-16">

    <x-public.section-header
        eyebrow="Kesiapsiagaan Bencana"
        title="Peta Bencana"
        subtitle="Kumpulan peta tingkat kerawanan bencana di Desa Ketapang berdasarkan kajian BPBD Kabupaten Banyuwangi, sebagai acuan mitigasi dan kesiapsiagaan warga."
        align="center"
    />

    @if($bencana)
        <div x-data="bencanaViewer('{{ $bencana->slug }}')" @popstate.window="syncFromUrl()">
            <div class="no-scrollbar mt-10 -mx-6 overflow-x-auto px-6">
                <div class="mx-auto flex w-max min-w-full flex-nowrap justify-center gap-2">
                    @foreach($bencanas as $b)
                        <a href="/bencana/{{ $b->slug }}"
                           @click.prevent="select('{{ $b->slug }}', @js($b->nama.' - Peta Digital Ketapang'))"
                           class="flex shrink-0 items-center justify-center whitespace-nowrap rounded-full px-4 py-2 text-sm font-medium transition-colors"
                           :class="activeSlug === '{{ $b->slug }}' ? 'bg-emerald-900 text-white shadow-sm' : 'bg-white text-neutral-600 ring-1 ring-black/10 hover:bg-emerald-50 hover:text-emerald-800'">
                            {{ $b->jenis_label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="mt-10 overflow-hidden rounded-2xl border border-neutral-200 bg-white shadow-sm">
                <div
                    class="relative touch-none select-none bg-neutral-50"
                    style="height: min(70vh, 640px);"
                    @wheel="onWheel($event)"
                    @mousedown="dragStart($event)"
                    @mousemove.window="dragMove($event)"
                    @mouseup.window="dragEnd()"
                    @touchstart="dragStart($event)"
                    @touchmove.prevent="dragMove($event)"
                    @touchend="dragEnd()"
                    :class="zoom > 1 ? 'cursor-grab active:cursor-grabbing' : ''"
                >
                    @foreach($bencanas as $b)
                        <div
                            x-show="activeSlug === '{{ $b->slug }}'"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="absolute inset-0"
                        >
                            @if($b->cover_foto)
                                <img
                                    src="{{ asset('storage/'.$b->cover_foto) }}"
                                    alt="{{ $b->nama }}"
                                    class="absolute left-1/2 top-1/2 h-full w-full max-w-full select-none object-contain"
                                    :style="'transform: translate(-50%, -50%) translate(' + panX + 'px,' + panY + 'px) scale(' + zoom + '); transition: ' + (dragging ? 'none' : 'transform 150ms ease') + ';'"
                                    draggable="false"
                                >

                                <p class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1.5 text-xs font-medium text-neutral-500 shadow-sm backdrop-blur">
                                    Geser untuk lihat detail &middot; scroll untuk zoom
                                </p>

                                <div class="absolute bottom-4 right-4 flex items-center gap-1 rounded-full bg-white/90 p-1.5 shadow-sm backdrop-blur">
                                    <button type="button" @click="zoomOut()" class="rounded-full p-2 text-neutral-700 transition hover:bg-neutral-100" aria-label="Perkecil">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                        </svg>
                                    </button>
                                    <span class="w-12 text-center text-xs font-medium tabular-nums text-neutral-600" x-text="Math.round(zoom * 100) + '%'"></span>
                                    <button type="button" @click="zoomIn()" class="rounded-full p-2 text-neutral-700 transition hover:bg-neutral-100" aria-label="Perbesar">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                                        </svg>
                                    </button>
                                    <button type="button" @click="reset()" class="ml-1 rounded-full border-l border-neutral-200 p-2 pl-3 text-neutral-700 transition hover:bg-neutral-100" aria-label="Reset tampilan">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M15 9h4.5M15 9V4.5M15 9l5.25-5.25M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" />
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <div class="flex h-full items-center justify-center text-neutral-400">
                                    Belum ada peta untuk kategori ini.
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                @foreach($bencanas as $b)
                    <div
                        x-show="activeSlug === '{{ $b->slug }}'"
                        x-transition:enter="transition ease-out duration-200 delay-75"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="border-t border-neutral-100 px-6 py-6 text-center sm:px-10"
                    >
                        <h2 class="font-serif text-xl font-bold text-emerald-900">{{ $b->nama }}</h2>
                        @if($b->deskripsi)
                            <p class="mx-auto mt-2 max-w-2xl text-sm leading-relaxed text-neutral-500">{{ $b->deskripsi }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="mt-10 rounded-2xl border border-neutral-200 bg-white p-10 text-center text-neutral-500 shadow-sm">
            Peta bencana belum diunggah admin.
        </div>
    @endif

</div>
@endsection
