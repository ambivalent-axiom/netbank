<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create account') }}
            </h2>
            @include('private.includes.flashmsgs_header')
        </div>
    </x-slot>
    <div class="py-2">
        <div class="mb-2 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap content-evenly mx-auto m-1 p-4 sm:p-8 bg-white shadow sm:rounded-lg lg:px-8 space-y-6">
                <form method="POST" action="">
                    @csrf
                    <div class="m-3">
                        <x-input-label>Currency
                            <select id="currency" name="currency" class="py-1 text-gray-700 bg-white border-none focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @foreach($mainCurrencies as $currency)
                                    <option>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </x-input-label>
                        <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                    </div>
                    <div class="m-3 mt-5">
                        <x-input-label>Account Type
                            <select id="type" name="type" class="py-1 text-gray-700 bg-white border-none focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @foreach($accountTypes as $type)
                                    <option>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </x-input-label>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>
                    <div class="mt-8">
                        <x-primary-button class="button" type="submit">
                            Create
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
