<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("Contacts") }}
            </h2>
            <!-- Check if there's a success message in the session -->
            @if(session('message'))
                <div class="text-sm text-yellow-600">
                    {{ session('message') }}
                </div>
            @endif
            @if(session('error'))
                <div class="text-sm text-red-600">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </x-slot>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex justify-between m-5">
                    <a href="/contacts/add">
                        <x-primary-button>Add contact</x-primary-button>
                    </a>
                    <h3 class="pr-3 pt-1 text-xl text-gray-800 leading-tight">
                        {{ Auth::user()->first_name }}{{ __(" associated contacts") }}
                    </h3>
                </div>
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse ">
                        <thead>
                        <tr>
                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                                First Name
                            </th>
                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Last Name
                            </th>
                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Email
                            </th>
                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                Delete
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contacts as $contact)
                            <tr>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ $contact->first_name }}
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ $contact->last_name }}
                                </td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{  $contact->email }}
                                </td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    <form id="contact" method="POST" action="/contacts/delete">
                                        @csrf
                                        @method('DELETE')
                                        <input id="contact" name="contact" type="hidden" value="{{ $contact->id }}">
                                        <x-secondary-button class="button" type="submit">X</x-secondary-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <x-input-error :messages="$errors->get('account')" class="mt-2" />
                </div>
                <div class="m-5 mb-6">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
