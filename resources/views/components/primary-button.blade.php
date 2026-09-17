<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full inline-flex items-center justify-center px-4 py-2.5 bg-clay-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-clay-700 focus:outline-none focus:ring-2 focus:ring-clay-400 focus:ring-offset-2 active:bg-clay-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>