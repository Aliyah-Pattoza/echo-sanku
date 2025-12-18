@props([
    'label',
    'value',
    'size' => 'lg',
    'highlight' => false,
])

<div>
    <p class="text-sm text-gray-600 mb-1">{{ $label }}</p>
    <p class="text-{{ $size }} font-semibold text-gray-800 {{ $highlight ? 'text-sanku-accent font-bold' : '' }}">
        {!! $value !!}
    </p>
</div>
