<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ Auth::user()->first_name }}{{ __(" associated accounts") }}
            </h2>
            @include('private.includes.flashmsgs_header')
        </div>
    </x-slot>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('private.accounts.includes.owned_accounts')
            @include('private.accounts.includes.shared_with_accounts')
        </div>
    </div>
</x-app-layout>
