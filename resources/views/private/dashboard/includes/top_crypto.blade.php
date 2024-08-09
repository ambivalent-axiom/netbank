<div class="mt-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between">
        <div class="m-6 text-gray-900">
            {{ __("Top Crypto Currencies") }}
        </div>
    </div>
    <div class="flex flex-col ml-3 mr-3 mb-3">
        @foreach($topCurrencies as $topCurrency)
            <div class="flex flex-row w-full bg-transparent border-collapse mb-2 text-xs">
                <div class="flex flex-wrap content-center rounded-l-lg bg-yellow-400 px-4 py-2 w-1/3 ">
                    <image src="{{ $topCurrency->logo ?? "" }}" width="28" heigth="28"></image>
                </div>
                <div class="rounded-r-lg bg-yellow-200 px-3 py-2 w-full">
                    <div class="flex justify-center font-semibold	">{{ $topCurrency->name }}</div>
                    <div class="flex justify-between">
                        <div class="text-base">{{ number_format($topCurrency->rate, 2) }}</div>
                        <div
                            @if($topCurrency->percent_changed >= 0)
                                class="text-green-600 text-sm"
                            @elseif($topCurrency->percent_changed < 0)
                                class="text-red-600 text-sm"
                            @endif
                        >{{ number_format($topCurrency->percent_changed, 4) }}</div>
                    </div>



                </div>
            </div>
        @endforeach
    </div>
</div>
