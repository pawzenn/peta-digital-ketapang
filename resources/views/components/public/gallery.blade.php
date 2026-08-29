@props(['images'])

@if($images && $images->count())
    @php
        $urls = $images->map(fn ($foto) => asset('storage/' . $foto->file_path))->all();
    @endphp

    <div class="mt-10" x-data="photoLightbox(@js($urls))">
        <h2 class="mb-4 text-xl font-semibold text-white">Gallery</h2>

        <div class="no-scrollbar -mx-6 flex gap-3 overflow-x-auto px-6 sm:mx-0 sm:grid sm:grid-cols-4 sm:gap-4 sm:overflow-visible sm:px-0">
            @foreach($images as $i => $foto)
                <button
                    type="button"
                    @click="show({{ $i }})"
                    class="aspect-square w-28 shrink-0 overflow-hidden rounded-lg transition hover:opacity-80 sm:w-auto"
                >
                    <img
                        src="{{ asset('storage/' . $foto->file_path) }}"
                        class="h-full w-full object-cover"
                        alt="Gallery"
                    >
                </button>
            @endforeach
        </div>

        {{-- LIGHTBOX --}}
        <div
            x-show="open"
            x-cloak
            @keydown.escape.window="close()"
            @keydown.arrow-right.window="next()"
            @keydown.arrow-left.window="prev()"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 p-4"
            @click.self="close()"
        >
            <button type="button" @click="close()" class="absolute right-4 top-4 rounded-full bg-white/10 p-2 text-white transition hover:bg-white/20" aria-label="Tutup">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            @if(count($urls) > 1)
                <p class="absolute left-4 top-4 rounded-full bg-white/10 px-3 py-1.5 text-xs font-medium text-white" x-text="(index + 1) + ' / ' + images.length"></p>

                <button type="button" @click.stop="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-2 text-white transition hover:bg-white/20 sm:left-6" aria-label="Sebelumnya">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12.5 15L7.5 10L12.5 5" />
                    </svg>
                </button>

                <button type="button" @click.stop="next()" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-white/10 p-2 text-white transition hover:bg-white/20 sm:right-6" aria-label="Berikutnya">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7.5 5L12.5 10L7.5 15" />
                    </svg>
                </button>
            @endif

            <img :src="current" alt="Gallery" class="max-h-[85vh] max-w-[90vw] rounded-lg object-contain shadow-2xl" @click.stop>
        </div>
    </div>
@endif
