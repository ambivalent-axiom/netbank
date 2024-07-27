<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transactions') }}
            </h2>
            @include('private.includes.flashmsgs_header')
        </div>
    </x-slot>


    <div class="py-2">
        <div class="mb-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="/transactions/create">
                        <x-primary-button>
                            Send Money
                        </x-primary-button>
                    </a>
                </div>
            </div>
        </div>



        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Transactions for: ") }}
                    {{ Auth::user()->first_name }}
                </div>
                <div>
                    @include('private.transactions.includes.transaction_table')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
