@props(['videos'])

@php
    $tiktokIcon = 'M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z';
    $cardBg = 'bg-[radial-gradient(circle_at_30%_20%,rgba(236,72,153,0.35),transparent_55%),radial-gradient(circle_at_75%_80%,rgba(34,211,238,0.30),transparent_55%)]';
@endphp

@if($videos && $videos->count())
    <div class="mt-14" x-data="{ scrollBy(d) { $refs.strip.scrollBy({ left: d * 260, behavior: 'smooth' }) } }">
        <div class="mb-5 flex items-end justify-between gap-4">
            <div>
                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-pink-300/80">
                    <span class="h-px w-6 bg-pink-300/50"></span>
                    Dari TikTok
                </p>
                <h2 class="mt-1 text-xl font-semibold text-white">Video Review</h2>
            </div>

            @if($videos->count() > 1)
                <div class="hidden gap-2 sm:flex">
                    <button type="button" @click="scrollBy(-1)" class="rounded-full bg-white/10 p-2 text-white transition hover:bg-white/20" aria-label="Sebelumnya">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.5 15L7.5 10L12.5 5" /></svg>
                    </button>
                    <button type="button" @click="scrollBy(1)" class="rounded-full bg-white/10 p-2 text-white transition hover:bg-white/20" aria-label="Berikutnya">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.5 5L12.5 10L7.5 15" /></svg>
                    </button>
                </div>
            @endif
        </div>

        <div x-ref="strip" class="no-scrollbar -mx-6 flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth px-6 pb-2 sm:mx-0 sm:px-0">
            @foreach($videos as $video)
                <div class="w-[220px] shrink-0 snap-start sm:w-[240px]" x-data="{ playing: false }">
                    <div class="relative aspect-[9/16] overflow-hidden rounded-2xl bg-neutral-900 shadow-xl shadow-black/40 ring-1 ring-white/10">

                        @if($video->embed_url)
                            <template x-if="playing">
                                <iframe
                                    src="{{ $video->embed_url }}"
                                    class="absolute inset-0 h-full w-full"
                                    style="border:0"
                                    allow="encrypted-media; fullscreen"
                                    allowfullscreen
                                    referrerpolicy="no-referrer-when-downgrade"
                                    title="{{ $video->caption ?: 'Video review TikTok' }}"
                                ></iframe>
                            </template>

                            <button
                                type="button"
                                x-show="!playing"
                                @click="playing = true"
                                class="group absolute inset-0 flex flex-col items-center justify-center {{ $cardBg }} text-white"
                                aria-label="Putar video"
                            >
                                <span class="flex h-16 w-16 items-center justify-center rounded-full bg-white/95 text-neutral-900 shadow-lg transition duration-300 group-hover:scale-110">
                                    <svg class="ml-1 h-7 w-7" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.14v13.72a1 1 0 0 0 1.52.85l11-6.86a1 1 0 0 0 0-1.7l-11-6.86A1 1 0 0 0 8 5.14z" /></svg>
                                </span>
                                <span class="mt-3 text-xs font-medium text-white/80">Putar video</span>

                                <svg class="absolute right-3 top-3 h-5 w-5 text-white/80" viewBox="0 0 24 24" fill="currentColor"><path d="{{ $tiktokIcon }}" /></svg>

                                @if($video->caption)
                                    <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/85 to-transparent px-4 pb-4 pt-12 text-left text-sm font-medium leading-snug text-white">
                                        {{ $video->caption }}
                                    </span>
                                @endif
                            </button>
                        @else
                            {{-- Link tidak bisa dijadikan embed: tampilkan kartu yang membuka TikTok --}}
                            <a href="{{ $video->url }}" target="_blank" rel="noopener"
                               class="group absolute inset-0 flex flex-col items-center justify-center {{ $cardBg }} px-4 text-center text-white">
                                <span class="flex h-14 w-14 items-center justify-center rounded-full bg-white/95 text-neutral-900 transition group-hover:scale-110">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="{{ $tiktokIcon }}" /></svg>
                                </span>
                                <span class="mt-3 text-sm font-semibold">Tonton di TikTok</span>
                                @if($video->caption)
                                    <span class="mt-1 text-xs text-white/70">{{ $video->caption }}</span>
                                @endif
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
