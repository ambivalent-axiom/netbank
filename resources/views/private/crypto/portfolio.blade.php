<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Crypto portfolio overview') }}
            </h2>
            <span>{{ __('Investment account: ') }}{{ $investmentAccount->id }}</span>
            @include('private.includes.flashmsgs_header')
        </div>
    </x-slot>
    <div class="py-2">
        <div class="mb-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Portfolio") }}
                </div>
                <div>
                    @include('private.crypto.includes.portfolio_table')
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Crypto Transactions for: ") }}
                    {{ Auth::user()->first_name }}
                </div>
                <div>
                    @include('private.crypto.includes.crypto_transaction_table')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
