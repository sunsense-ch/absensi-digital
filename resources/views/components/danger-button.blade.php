<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2.5 bg-danger-500 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-danger-600 focus:outline-none focus:ring-2 focus:ring-danger-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>