@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'nav-link-a inline-flex items-center px-1 pt-1 pb-0 border-b-4 border-blue-800 rounded leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
                : 'nav-link-a inline-flex items-center px-1 pt-1 border-b-4 border-transparent leading-5 hover:border-gray-300 rounded focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>