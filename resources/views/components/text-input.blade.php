@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-lg border-neutral-300 shadow-sm focus:border-emerald-700 focus:ring-emerald-700']) }}>
