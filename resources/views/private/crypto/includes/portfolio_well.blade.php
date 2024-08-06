<div class="mb-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between">
        <div class="m-6 text-gray-900">
            {{ __("Portfolio") }}
        </div>
        <div class="m-5">
            <a href="/crypto/portfolio">
                <x-primary-button>Open</x-primary-button>
            </a>
        </div>
    </div>
    <div class="ml-5 mb-2">
        <div>
            Available to invest: {{ number_format($investmentAccount->balance/100, 2) }} USD
        </div>
        <div>
            Total invested:
            <span id="total_sum"></span>
             USD
        </div>
    </div>
    <div class="flex flex-col ml-3 mr-3 mb-3">
        @foreach($portfolio as $record)
            <div class="flex flex-row w-full bg-transparent border-collapse mb-2 text-xs">
                <div class="rounded-l-lg bg-yellow-400 px-4 py-2 w-1/3 ">
                    {{ $record->symbol }}
                </div>
                <div class="flex justify-between rounded-r-lg bg-yellow-200 px-3 py-2 w-full">
                    {{ $record->amount }}
                    <span class="amount_usd">
                        {{ number_format($record->withProfitUSD($record->currencies[0]->rate), 2, '.', '')}}
                    </span>
                    <span
                        @if(($profit = $record->profitPercent($record->currencies[0]->rate)) >= 0)
                            class="text-green-600"
                        @elseif($profit < 0)
                            class="text-red-600"
                        @endif
                    >{{ number_format($profit, 2) }}{{ __('%') }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>
