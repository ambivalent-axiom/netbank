<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Sell ') }}{{ $currency->name }}
            </h2>
            <span>{{ __('Investment account: ') }}{{ $investmentAccount->id }}</span>
            @include('private.includes.flashmsgs_header')
        </div>
    </x-slot>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div>
                    @include('private.crypto.includes.sell_form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
