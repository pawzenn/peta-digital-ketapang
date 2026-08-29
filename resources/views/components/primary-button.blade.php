<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-md bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 active:bg-orange-700']) }}>
    {{ $slot }}
</button>
