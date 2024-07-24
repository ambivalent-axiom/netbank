@props(['active'])

@php
$classes = ($active ?? false)
            ? 'sm:ms-5 inline-flex rounded-xl items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 drop-shadow-md transition duration-500 ease-in-out'
            : 'sm:ms-5 inline-flex rounded-xl items-center px-1 pt-1 text-sm font-medium leading-5 text-yellow-100 hover:text-yellow-900 hover:border-yellow-800 focus:outline-none drop-shadow-md focus:text-yellow-700 focus:border-yellow-300 transition duration-500 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

