@props(['rating'])

@if($rating)
    <span class="inline-flex items-center gap-1.5 rounded-md bg-black/80 px-2.5 py-1 text-sm font-semibold text-white">
        <svg class="h-4 w-4 fill-amber-400" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
        {{ number_format($rating, 1) }}
    </span>
@endif
