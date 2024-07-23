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
            <div class="w-2/3 pr-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        {{ __("You are logged In!") }}
                    </div>
                    <div class="block w-full overflow-x-auto">
                    </div>
                </div>
            </div>
            <div class="w-1/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between">
                        <div class="m-6 text-gray-900">
                            {{ __("Contacts") }}
                        </div>
                        <div class="m-5">
                            <a href="/contacts">
                                <x-primary-button>Edit</x-primary-button>
                            </a>
                        </div>
                    </div>


                    <div class="flex flex-col m-3">
                        @foreach($contacts as $contact)
                            <div class="flex flex-row bg-transparent w-full border-collapse mb-2 text-xs">
                                <div class="rounded-l-lg bg-yellow-400 px-4 py-2 w-1/3 ">
                                    {{ $contact->first_name }}
                                </div>
                                <div class="rounded-r-lg bg-yellow-200 px-3 py-2 w-full">
                                    {{ $contact->email }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
