<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            @include('private.includes.flashmsgs_header')
        </div>
    </x-slot>
    <div class="py-2">
        <div class="flex max-w-7xl mx-auto sm:px-6 lg:px-8" id="contacts">

{{--            central--}}

            <div class="w-2/3 pr-3">
                @if($userMessages)
                    @include('private.dashboard.includes.messages')
                @endif
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @include('private.dashboard.includes.article')
                    </div>
                    <div class="block w-full overflow-x-auto">
                    </div>
                </div>
            </div>
{{--            side--}}
            <div class="w-1/3">
                @include('private.dashboard.includes.balance')
                @include('private.dashboard.includes.contacts')
                @if($investmentAccount)
                    @include('private.crypto.includes.portfolio_well')
                @endif
                @include('private.dashboard.includes.top_crypto')
            </div>
        </div>
    </div>
</x-app-layout>
