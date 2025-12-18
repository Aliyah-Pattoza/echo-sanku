@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-sanku-accent text-left text-base font-medium text-white bg-sanku-dark focus:outline-none focus:text-sanku-accent focus:bg-sanku-dark focus:border-sanku-accent transition duration-150 ease-in-out'
            : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-white hover:text-sanku-accent hover:bg-sanku-dark hover:border-sanku-cream focus:outline-none focus:text-sanku-accent focus:bg-sanku-dark focus:border-sanku-cream transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>