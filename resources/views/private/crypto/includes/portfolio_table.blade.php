<div class="block w-full overflow-x-auto">
    <table class="items-center bg-transparent w-full border-collapse ">
        <thead>
        <tr>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                Opened since
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                Symbol
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                Name
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                Amount
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                Total invested USD
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                Profit
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                %
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                Operation
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($portfolio as $record)
            <tr id="transaction"
                class="bg-yellow-100"
            >
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    <image src="{{ $record->currencies[0]->logo }}" width="40" height="40"></image>
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    {{ $record->created_at }}
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                <span>
                    {{ $record->symbol }}
                </span>
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    {{ $record->currency_name }}
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    {{ $record->amount }}
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    {{ number_format(($invested = $record->investedUSD()), 2)}}
                </td>
                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    @php
                        $profitUSD = $record->profitUSD()
                    @endphp
                    <span
                        @if(number_format($profitUSD, 2) < 0)
                            class="text-red-600"
                        @else
                            class="text-green-600"
                        @endif
                    >
                        {{ number_format($profitUSD, 2) }}
                    </span>
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    @php
                        $profitPercent = $record->profitPercent()
                    @endphp
                    <span
                        @if($profitPercent >= 0)
                            class="text-green-600"
                        @elseif($profitPercent < 0)
                            class="text-red-600"
                        @endif
                    >
                        {{ number_format($profitPercent, 2) }}
                    </span>
                </td>
                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    <form method="POST" action="/crypto/sell">
                        @csrf
                        <x-text-input
                            id="symbol"
                            name="symbol"
                            value=" {{ $record->symbol }} "
                            hidden></x-text-input>
                        <x-text-input
                            id="name"
                            name="name"
                            value=" {{ $record->currency_name }} "
                            hidden></x-text-input>
                        <x-secondary-button type="submit" class="button">Sell</x-secondary-button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <x-input-error :messages="$errors->get('portfolio')" class="mt-2" />
</div>

