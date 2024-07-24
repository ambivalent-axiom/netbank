<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Shared account administration') }}
            </h2>
            @include('private.includes.flashmsgs_header')
        </div>
    </x-slot>

    <div class="py-2">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">
                    <div class="flex flex-wrap content-evenly m-1">
                        @foreach($accounts as $account)
                            <div class="mb-2 flex flex-col w-full p-2 bg-yellow-200 shadow sm:rounded-lg">
                                <div class="flex justify-between">
                                    <div class="p-2 font-semibold">
                                        <span>{{ $account->id }}</span>
                                        <span class="ml-4">{{ $account->currency }}</span>
                                    </div>
                                    <div>
                                        <form method="POST" action="" class="p-1">
                                            @csrf
                                            @method('PUT')
                                            <input id="account" name="account" type="hidden" value="{{ $account->id }}">
                                            <select id="contact" name="contact" class="py-1 text-gray-700 bg-white border-none focus:outline-none focus:ring-2 focus:ring-yellow-100 sm:rounded-lg">
                                                <option value="" disabled selected>Select Contact</option>
                                                @foreach($contacts as $contact)
                                                    <option value="{{ $contact->id }}">
                                                        {{ $contact->first_name . " " . $contact->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-secondary-button type="submit" class="button p-1 ml-5">
                                                Share
                                            </x-secondary-button>
                                        </form>
                                    </div>
                                </div>

                                @foreach($sharedAccounts as $sharedAccount)
                                    @if($sharedAccount->account_id == $account->id)
                                        <div class="flex justify-between mb-1 w-full p-1 bg-white sm:rounded-lg">
                                            <div class="flex">
                                                <p class="ml-3">{{ $sharedAccount->sharedUser->first_name }}</p>
                                                <p class="ml-3">{{ $sharedAccount->sharedUser->last_name }}</p>
                                                <p class="ml-3">{{ $sharedAccount->sharedUser->type }}</p>
                                                <p class="ml-3">{{ $sharedAccount->sharedUser->email }}</p>
                                            </div>
                                            <div>
                                                <form id="delete_shared_account_id" method="POST" action="">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input id="delete_shared_account_id" name="delete_shared_account_id" type="hidden" value="{{ $sharedAccount->id }}">
                                                    <button class="button mr-3 hover:text-yellow-400" type="submit">Remove</button>
                                                </form>
                                            </div>

                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

