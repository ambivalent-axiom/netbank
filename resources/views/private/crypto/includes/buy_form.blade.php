<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex flex-wrap content-evenly m-4">
        <form method="POST" action="" class="w-full">
            @csrf
            @method('PUT')
            <div class="mb-2 flex flex-col w-full p-2 bg-yellow-200 shadow sm:rounded-lg content-evenly flex-shrink-0">
                <div class="flex w-full flex-shrink-0">
                    <div class="flex-shrink-0 ml-3 content-center">
                        <image src="{{ $currency->logo ?? ' ' }}" width="64" height="64"></image>
                    </div>
                    <div class="ml-3 mt-1 content-center">
                        <x-input-label>
                            {{ $currency->name }}
                            <x-text-input
                                id="currency_name"
                                name="currency_name"
                                value="{{ $currency->name }}"
                                required
                                hidden
                            >
                            </x-text-input>
                        </x-input-label>
                        <x-input-error :messages="$errors->get('currency_name')" class="mt-2" />
                        <x-input-label>
                            {{ $currency->symbol }}
                            <x-text-input
                                id="currency_symbol"
                                name="currency_symbol"
                                value="{{ $currency->symbol }}"
                                required
                                hidden
                            >
                            </x-text-input>
                            <x-input-error :messages="$errors->get('currency_name')" class="mt-2" />
                        </x-input-label>
                    </div>
                    <div class="w-full flex flex-col content-center ml-5 mr-5 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <div>{{ __('Current price: ') }}</div>
                            <div>{{ number_format($currency->rate, 2) }}</div>
                            <div id="current_price" hidden>{{ $currency->rate }}</div>
                        </div>
                        <div class="flex justify-between">
                            <div>{{ __('Last update: ') }}</div>
                            <div>{{ $currency->updated_at }}</div>
                        </div>
                        <div class="flex justify-between">
                            <div>{{ __('% changes in last 24h: ') }}</div>
                            <div
                                @if($currency->percent_changed < 0)
                                    class="text-red-600"
                                @elseif($currency->percent_changed >= 0)
                                    class="text-green-600"
                                @endif
                            >
                                {{ number_format($currency->percent_changed, 4) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="flex justify-between m-2 ml-2">
                    <x-input-label>{{ $currency->symbol }}
                        <x-text-input
                            id="crypto_amount"
                            name="crypto_amount"
                            required
                        ></x-text-input>
                    </x-input-label>
                    <x-input-label>{{ __('USD') }}
                        <x-text-input
                            id="usd_amount"
                            name="usd_amount"
                            value=""
                            required
                        ></x-text-input>
                    </x-input-label>
                    <x-input-error :messages="$errors->get('crypto_amount')" class="mt-2" />

                </div>
                <div class="mt-10">
                    <x-primary-button class="button" type="submit">
                        Place order
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</div>
