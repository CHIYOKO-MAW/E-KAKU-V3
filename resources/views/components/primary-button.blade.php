<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-md bg-disnaker-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-disnaker-600 focus:outline-none focus:ring-2 focus:ring-disnaker-500 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
