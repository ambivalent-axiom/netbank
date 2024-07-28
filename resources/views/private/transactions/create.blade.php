<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create transaction') }}
            </h2>
            @include('private.includes.flashmsgs_header')
        </div>
    </x-slot>
    <div class="py-2">
        <div class="mb-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    @include('private.transactions.includes.create_form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
