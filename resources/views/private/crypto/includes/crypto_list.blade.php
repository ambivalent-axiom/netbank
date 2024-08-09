<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between m-5">
        <h3 class="content-center pr-3 pt-1 text-xl text-gray-800 leading-tight">
            {{ __("Crypto currency list by Rank") }}
        </h3>
        <div>
            <x-input-label for="search"></x-input-label>
            <x-text-input id="search" type="text" placeholder="Filter..."></x-text-input>
        </div>
    </div>
    <div class="m-5 mb-6">
        {{ $currencies->links() }}
    </div>
    <div class="block w-full overflow-x-auto">
        <table class="items-center bg-transparent w-full border-collapse ">
            <thead>
            <tr>
                <th class="px-4 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">

                </th>
                <th class="px-4 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                    Ticker
                </th>
                <th class="px-4 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                    Name
                </th>
                <th class="px-4 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                    Price
                </th>
                <th class="px-4 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                    24h
                </th>
                <th class="px-4 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                    Updated
                </th>
                <th class="px-4 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">

                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($currencies as $currency)
                <tr class="bg-yellow-100 hover:bg-yellow-300 flex-shrink-0">
                    <td class="ml-4 border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 flex-shrink-0">
                        <image
                            src="{{ $currency->logo ?? ' ' }}"
                            width="38"
                            height="38">
                        </image>
                    </td>
                    <td class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                        {{ $currency->symbol }}
                    </td>
                    <td class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                        {{ $currency->name }}
                    </td>
                    <td class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                        {{ number_format($currency->rate, 4) }}
                    </td>
                    <td class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                        @if($currency->percent_changed < 0)
                            <span class="text-red-600">
                        @elseif($currency->percent_changed >= 0)
                            <span class="text-green-600">
                        @endif
                        {{ number_format($currency->percent_changed, 4) }} </span>
                    </td>
                    <td class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                        {{ $currency->updated_at }}
                    </td>
                    <td class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xl whitespace-nowrap p-4">
                        <a href="/crypto/buy/{{ $currency->name }}">🛒</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <x-input-error :messages="$errors->get('account')" class="mt-2" />
    </div>
</div>
