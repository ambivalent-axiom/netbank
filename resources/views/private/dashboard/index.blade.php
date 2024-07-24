<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <x-flashmsg></x-flashmsg>
        </div>
    </x-slot>
    <div class="py-2">
        <div class="flex max-w-7xl mx-auto sm:px-6 lg:px-8" id="contacts">

{{--            main--}}
            <div class="w-2/3 pr-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("You are logged In!") }}
                    </div>
                    <div class="block w-full overflow-x-auto">
                    </div>
                </div>
            </div>

{{--            sidewell--}}
            <div class="w-1/3">
                <div class="mb-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between">
                        <div class="m-6 text-gray-900">
                            {{ __("Balance Total") }}
                        </div>
                    </div>
                </div>

                @include('private.dashboard.includes.contacts')
            </div>
        </div>
    </div>
</x-app-layout>
