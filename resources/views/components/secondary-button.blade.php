<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2.5 bg-white border border-mist-200 rounded-xl font-semibold text-sm text-dusk-700 shadow-sm hover:bg-sand-50 focus:outline-none focus:ring-2 focus:ring-dusk-300 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>