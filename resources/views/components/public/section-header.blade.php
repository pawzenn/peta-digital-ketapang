@props([
    'eyebrow' => null,
    'title',
    'subtitle' => null,
    'href' => null,
    'align' => 'center',
])

@php
    $wrapClass = match ($align) {
        'left' => 'text-left mr-auto',
        'right' => 'text-right ml-auto',
        default => 'text-center mx-auto',
    };
    $subtitleClass = match ($align) {
        'left' => 'mr-auto',
        'right' => 'ml-auto',
        default => 'mx-auto',
    };
@endphp

<div class="max-w-2xl {{ $wrapClass }}">
    @if($eyebrow)
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-orange-600">{{ $eyebrow }}</p>
    @endif

    <h2 class="{{ $eyebrow ? 'mt-2' : '' }} font-serif text-3xl font-bold text-emerald-900">{{ $title }}</h2>

    @if($subtitle)
        <p class="{{ $subtitleClass }} mt-3 max-w-xl text-neutral-600">{{ $subtitle }}</p>
    @endif

    @if($href)
        <a href="{{ $href }}" class="mt-4 inline-block text-sm font-medium text-neutral-500 underline-offset-4 hover:underline">
            Lihat semua &rarr;
        </a>
    @endif
</div>
