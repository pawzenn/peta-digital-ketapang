@props(['link' => null, 'embed' => null])

@if($link)
    @php
        $btn = 'inline-flex items-center gap-2 rounded-md bg-gradient-to-r from-pink-500 to-fuchsia-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-pink-900/30 transition hover:brightness-110';
    @endphp

    @if($embed)
        <div x-data="{ open: false }" class="inline-block">
            <button type="button" @click="open = true" class="{{ $btn }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.14v13.72a1 1 0 0 0 1.52.85l11-6.86a1 1 0 0 0 0-1.7l-11-6.86A1 1 0 0 0 8 5.14z" /></svg>
                Lihat Rute (Video)
            </button>

            <div
                x-show="open"
                x-cloak
                x-transition.opacity
                @keydown.escape.window="open = false"
                @click.self="open = false"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
            >
                <button type="button" @click="open = false" class="absolute right-4 top-4 rounded-full bg-white/10 p-2 text-white transition hover:bg-white/20" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>

                <div class="aspect-[9/16] max-h-[88vh] w-full max-w-[380px] overflow-hidden rounded-2xl bg-neutral-900 shadow-2xl ring-1 ring-white/10" @click.stop>
                    <template x-if="open">
                        <iframe
                            src="{{ $embed }}"
                            class="h-full w-full"
                            style="border:0"
                            allow="encrypted-media; fullscreen"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Video rute"
                        ></iframe>
                    </template>
                </div>
            </div>
        </div>
    @else
        <a href="{{ $link }}" target="_blank" rel="noopener" class="{{ $btn }}">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.14v13.72a1 1 0 0 0 1.52.85l11-6.86a1 1 0 0 0 0-1.7l-11-6.86A1 1 0 0 0 8 5.14z" /></svg>
            Lihat Rute (Video)
        </a>
    @endif
@endif
