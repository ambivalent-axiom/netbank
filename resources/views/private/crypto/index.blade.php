<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Crypto') }}
            </h2>
            @include('private.includes.flashmsgs_header')
        </div>
    </x-slot>
    <div class="py-2">
        <div class="flex max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{--            central--}}
            <div class="w-2/3 pr-3">
                @include('private.crypto.includes.crypto_list')
            </div>
            {{--            side--}}
            <div class="w-1/3">
                @include('private.crypto.includes.search_well')
                @include('private.crypto.includes.portfolio_well')
            </div>
        </div>
    </div>
</x-app-layout>
