@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-dusk-800']) }}>
    {{ $value ?? $slot }}
</label>