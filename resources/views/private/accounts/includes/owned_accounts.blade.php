<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex justify-between m-5">
        <div>
            <a href="/accounts/create">
                <x-primary-button>Add account</x-primary-button>
            </a>
            <a href="/accounts/share">
                <x-primary-button>Share account</x-primary-button>
            </a>
        </div>
        <h3 class="pr-3 pt-1 text-xl text-gray-800 leading-tight">
            {{ Auth::user()->first_name }}{{ __(" owned accounts") }}
        </h3>
    </div>
    <div class="block w-full overflow-x-auto">
        <table class="items-center bg-transparent w-full border-collapse ">
            <thead>
            <tr>
                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                </th>
                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                    Account Id
                </th>
                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                    Type
                </th>
                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                    Currency
                </th>
                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                    Balance
                </th>
                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($accounts as $account)
                <tr>
                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                        @if($account->id == Auth::user()->default_account)
                            ★
                        @endif
                    </th>
                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                        {{ $account->id }}
                    </th>
                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                        {{ $account->type }}
                    </td>
                    <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                        {{ $account->currency }}
                    </td>
                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                        {{  $account->balance }}
                    </td>
                    <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                        @if($account->id != Auth::user()->default_account)
                            <a href="/accounts/{{ $account->id }}/default" class="hover:text-yellow-600">
                                Default
                            </a>
                            |
                            <a href="/accounts/{{ $account->id }}/destroy" class="hover:text-yellow-600">
                                Delete
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <x-input-error :messages="$errors->get('account')" class="mt-2" />
    </div>
    <div class="m-5 mb-6">
        {{ $accounts->links() }}
    </div>
</div>
