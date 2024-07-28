<div class="block w-full overflow-x-auto">
    <table class="items-center bg-transparent w-full border-collapse ">
        <thead>
        <tr>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                Type
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                Status
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                Date Time
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                Account
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold">
                Currency
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                Amount
            </th>
            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                Beneficiary/Sender
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($transactions as $transaction)
            <tr>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    @if($transaction->type == 'outgoing')
                        <span class="text-red-800 text-xl">{{ __("▲") }}</span>
                    @elseif($transaction->type == 'incoming')
                        <span class="text-green-800 text-xl">{{ __("▼") }}</span>
                    @endif
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    <span
                        @if($transaction->status == 'failed')
                            class="text-red-800"
                        @elseif($transaction->status  == 'completed')
                            class="text-green-800"
                        @else
                            class="text-yellow-800"
                        @endif
                    >
                        {{ $transaction->status }}
                    </span>
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    {{ $transaction->created_at }}
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    @if($transaction->type == 'outgoing')
                        {{ $transaction->sender_account_id }}
                    @elseif($transaction->type == 'incoming')
                        {{ $transaction->recipient_account_id }}
                    @endif
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    @if($transaction->type == 'outgoing')
                        {{ $transaction->orig_currency }}
                    @elseif($transaction->type == 'incoming')
                        {{ $transaction->final_currency }}
                    @endif
                </td>
                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    @if($transaction->type == 'outgoing')
                        {{ number_format($transaction->sent_amount/100, 2) }}
                    @elseif($transaction->type == 'incoming')
                        {{ number_format($transaction->received_amount/100, 2)}}
                    @endif
                </td>
                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    @if($transaction->type == 'outgoing')
                        {{ $transaction->recipient_name }}
                    @elseif($transaction->type == 'incoming')
                        {{ $transaction->sebder_name }}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <x-input-error :messages="$errors->get('account')" class="mt-2" />
</div>
<div class="m-5 mb-6">
{{--    {{ $accounts->links() }}--}}
</div>
