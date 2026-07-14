@props([
    'items',
    'interval' => 5000,
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
                        aspect-class="aspect-[4/3]"
                        rounded-class="rounded-none"
                    />
                </div>
            @endforeach
        </div>
    </div>

    @if($total > 1)
        <div class="mt-4 flex justify-center gap-2">
            @foreach($items as $i => $item)
                <button
                    type="button"
                    @click="goTo({{ $i }})"
                    :class="realIndex() === {{ $i }} ? 'w-8 bg-emerald-800' : 'w-4 bg-neutral-300'"
                    class="h-1.5 rounded-full transition-all duration-300"
                    aria-label="Slide {{ $i + 1 }}"
                ></button>
            @endforeach
        </div>
    @endif
</div>
