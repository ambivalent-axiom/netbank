@props(['active'])

@php
$classes = ($active ?? false)
            ? 'sm:ms-5 inline-flex rounded-xl items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-500 ease-in-out'
            : 'sm:ms-5 inline-flex rounded-xl items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-gray-900 hover:border-gray-800 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-500 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

