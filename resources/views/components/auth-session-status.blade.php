@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-success-600 bg-success-50 rounded-xl px-4 py-3']) }}>
        {{ $status }}
    </div>
@endif