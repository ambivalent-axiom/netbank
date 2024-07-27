<div class="flex flex-wrap content-evenly m-1">
    <form method="POST" action="">
        @csrf
        @method('PUT')
        <div class="mb-2 flex flex-col w-full p-2 bg-yellow-200 shadow sm:rounded-lg">
            <div class="flex justify-between">
                <div class="ml-3">
                    <x-input-label>
                        Amount to send
                        <x-text-input
                            id="amount"
                            name="amount"
                            required
                        >
                        </x-text-input>
                    </x-input-label>
                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                </div>
                <div>
                    <x-input-label class="ml-5 mb-10">From account
                        <select
                            id="from_account"
                            name="from_account"
                            class="py-1 rounded-lg text-gray-700 bg-white border-none focus:outline-none focus:ring-2 focus:ring-blue-100"
                            required
                        >
                            <option value="" disabled selected>Select FROM account</option>
                            @foreach($accounts as $account)
                                <option
                                    value="{{ $account->id }}"
                                    data-currency="{{ $account->currency }}"
                                    data-balance="{{ number_format($account->balance/100, 2) }}"
                                >
                                    {{ $account->id }}
                                </option>
                            @endforeach
                        </select>
                    </x-input-label>
                    <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                </div>
            </div>
                <div class="ml-3">
                    <span id="currency" class="text-lg"></span>
                </div>
                <div class="ml-3">
                    <span id="balance" class="text-3xl"></span>
                </div>
        </div>
        <div class="m-3 mt-5">
            <x-input-label>Send to
                <select id="contact" name="contact" class="py-1 rounded-lg text-gray-700 bg-white border-none focus:outline-none focus:ring-2 focus:ring-blue-100">
                    <option value="" selected>Manually defined account</option>
                    @foreach($contacts as $contact)
                        <option
                            value="{{ $contact->id }}"
                            data-account="{{ $contact->default_account }}"
                        >
                            {{ $contact->first_name }} {{ $contact->last_name }}
                        </option>
                    @endforeach
                </select>
            </x-input-label>
            <x-input-error :messages="$errors->get('contact')" class="mt-2" />
        </div>
        <div class="m-3 mt-5">
            <x-input-label>Beneficiary account
                <x-text-input
                    id="receiver_account"
                    name="receiver_account"
                    value=""
                    class="w-96"
                    required
                ></x-text-input>
            </x-input-label>
            <x-input-error :messages="$errors->get('receiver_account')" class="mt-2" />
        </div>
        <div class="mt-10">
            <x-primary-button class="button" type="submit">
                Send
            </x-primary-button>
        </div>
    </form>
</div>
