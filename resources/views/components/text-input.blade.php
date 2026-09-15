@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-mist-200 bg-white text-dusk-900 placeholder:text-dusk-400 focus:border-clay-500 focus:ring-clay-500 rounded-xl shadow-sm text-sm']) !!}>