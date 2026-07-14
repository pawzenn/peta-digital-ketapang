@props([
    'nama',
    'deskripsi' => null,
    'coverUrl' => null,
    'detailUrl',
    'rating' => null,
    'badge' => null,
    'aspectClass' => 'aspect-[4/3]',
    'roundedClass' => 'rounded-xl',
])

<a href="{{ $detailUrl }}" class="group block overflow-hidden {{ $roundedClass }} bg-neutral-900 shadow-sm ring-1 ring-black/5 transition-shadow hover:shadow-lg">
    <div class="relative {{ $aspectClass }} overflow-hidden">
        @if($coverUrl)
            <img
                src="{{ $coverUrl }}"
                alt="{{ $nama }}"
                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
            >
        @else
            <div class="flex h-full w-full items-center justify-center bg-neutral-800 text-sm text-neutral-400">
                Tidak ada foto
            </div>
        @endif

        @if($badge)
            <span class="absolute left-3 top-3 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-neutral-800 shadow">
                {{ $badge }}
            </span>
        @endif

        @if($rating)
            <span class="absolute bottom-3 right-3 inline-flex items-center gap-1 rounded-md bg-black/80 px-2 py-1 text-xs font-semibold text-white">
                <svg class="h-3 w-3 fill-amber-400" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                {{ number_format($rating, 1) }}
            </span>
        @endif

        <div class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent px-4 pb-4 pt-12">
            <h3 class="text-base font-semibold text-white">{{ $nama }}</h3>
            @if($deskripsi)
                <p class="mt-1 line-clamp-2 text-xs text-white/80 {{ $rating ? 'pr-16' : '' }}">
                    {{ $deskripsi }}
                </p>
            @endif
        </div>
    </div>
</a>
