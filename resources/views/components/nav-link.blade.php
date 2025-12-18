@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-sanku-accent text-sm font-medium leading-5 text-white focus:outline-none focus:border-sanku-accent transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-sanku-accent hover:border-sanku-cream focus:outline-none focus:text-sanku-accent focus:border-sanku-cream transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>