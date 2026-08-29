@props([
    'items',
    'interval' => 5000,
    'indicatorStyle' => 'dots',
])

@php
    $total = count($items);
    $extended = $total > 1
        ? array_merge([$items[$total - 1]], $items, [$items[0]])
        : $items;
@endphp

<div
    @if($total > 1)
        x-data="carousel({{ $total }}, {{ $interval }})"
    @endif
>
    <div
        class="relative overflow-hidden {{ $total > 1 ? 'cursor-grab select-none active:cursor-grabbing' : '' }}"
        @if($total > 1)
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
            class="flex"
            @if($total > 1)
                :style="'transition:' + trackTransition() + '; transform: translateX(calc(-' + active + ' * 64% + 18% + ' + deltaX + 'px))'"
            @endif
        >
            @foreach($extended as $item)
                <div class="{{ $total > 1 ? 'w-[64%]' : 'w-full' }} flex-shrink-0">
                    <x-public.card
                        :nama="$item['nama']"
                        :deskripsi="$item['deskripsi'] ?? null"
                        :cover-url="$item['coverUrl'] ?? null"
                        :detail-url="$item['detailUrl']"
                        :rating="$item['rating'] ?? null"
                        :badge="$item['badge'] ?? null"
                        :target="$item['target'] ?? null"
                        aspect-class="aspect-[4/3]"
                        rounded-class="rounded-none"
                    />
                </div>
            @endforeach
        </div>

        @if($total > 1)
            <button
                type="button"
                @click="manualPrev()"
                class="absolute left-2 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/80 p-2 text-neutral-800 shadow-md transition hover:bg-white sm:left-4 sm:p-3"
                aria-label="Sebelumnya"
            >
                <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12.5 15L7.5 10L12.5 5" />
                </svg>
            </button>

            <button
                type="button"
                @click="manualNext()"
                class="absolute right-2 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/80 p-2 text-neutral-800 shadow-md transition hover:bg-white sm:right-4 sm:p-3"
                aria-label="Berikutnya"
            >
                <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M7.5 5L12.5 10L7.5 15" />
                </svg>
            </button>
        @endif
    </div>

    @if($total > 1)
        <div class="mt-4 flex flex-wrap justify-center gap-2">
            @foreach($items as $i => $item)
                @if($indicatorStyle === 'labeled')
                    <button
                        type="button"
                        @click="goTo({{ $i }})"
                        :class="realIndex() === {{ $i }} ? 'border-emerald-800 bg-emerald-800 text-white' : 'border-neutral-300 bg-white text-neutral-600 hover:border-emerald-800 hover:text-emerald-800'"
                        class="rounded-md border px-3 py-1.5 text-xs font-medium transition-colors"
                    >
                        {{ $item['label'] ?? $item['nama'] }}
                    </button>
                @else
                    <button
                        type="button"
                        @click="goTo({{ $i }})"
                        :class="realIndex() === {{ $i }} ? 'w-8 bg-emerald-800' : 'w-4 bg-neutral-300'"
                        class="h-1.5 rounded-full transition-all duration-300"
                        aria-label="Slide {{ $i + 1 }}"
                    ></button>
                @endif
            @endforeach
        </div>
    @endif
</div>
