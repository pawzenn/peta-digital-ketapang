@props(['awards', 'compact' => false])

@if($awards && $awards->count())
    @php
        $wrap = $compact ? 'mt-5' : 'mt-8';
        $label = $compact ? 'mb-2 text-[10px] tracking-[0.18em]' : 'mb-3 text-xs tracking-[0.2em]';
        $gap = $compact ? 'gap-2' : 'gap-3';
        $badge = $compact ? 'gap-2 rounded-xl py-1.5 pl-1.5 pr-3' : 'gap-3 rounded-2xl py-2.5 pl-2.5 pr-5';
        $icon = $compact ? 'h-8 w-8' : 'h-11 w-11';
        $svg = $compact ? 'h-4 w-4' : 'h-6 w-6';
        $name = $compact ? 'text-xs' : 'text-sm';
        $sub = $compact ? 'text-[11px]' : 'text-xs';
    @endphp

    <div class="{{ $wrap }}">
        <p class="{{ $label }} flex items-center gap-2 font-semibold uppercase text-amber-300/90">
            <span class="h-px w-5 bg-amber-300/60"></span>
            Penghargaan
        </p>

        <div class="flex flex-wrap {{ $gap }}">
            @foreach($awards as $award)
                <div class="group flex items-center {{ $badge }} bg-gradient-to-br from-amber-300/25 via-amber-400/10 to-amber-600/5 ring-1 ring-amber-300/40 shadow-[0_0_24px_-6px_rgba(251,191,36,0.45)] backdrop-blur-sm transition duration-300 hover:-translate-y-0.5 hover:ring-amber-300/70 hover:shadow-[0_0_32px_-4px_rgba(251,191,36,0.6)]">
                    <span class="flex {{ $icon }} shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-amber-200 to-amber-500 text-amber-950 shadow-inner ring-2 ring-amber-100/50 transition duration-300 group-hover:rotate-6 group-hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="{{ $svg }}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                        </svg>
                    </span>

                    <span class="min-w-0">
                        <span class="block {{ $name }} font-semibold leading-snug text-amber-100">{{ $award->nama }}</span>

                        @if($award->pemberi || $award->tahun)
                            <span class="block {{ $sub }} text-amber-200/70">
                                {{ collect([$award->pemberi, $award->tahun])->filter()->implode(' · ') }}
                            </span>
                        @endif
                    </span>
                </div>
            @endforeach
        </div>
    </div>
@endif
