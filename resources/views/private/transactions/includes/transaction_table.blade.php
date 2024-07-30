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
            <tr id="transaction"
                class="bg-yellow-100 hover:bg-yellow-300 rounded"
                onclick="openTransactionModal({
                    id: '{{ $transaction->id }}',
                    type: '{{ $transaction->type }}',
                    status: '{{ $transaction->status }}',
                    created_at: '{{ $transaction->created_at }}',
                    sender_account: '{{ $transaction->sender_account_id }}',
                    orig_currency: '{{ $transaction->orig_currency }}',
                    sent_amount: '{{ number_format($transaction->sent_amount/100, 2) }}',
                    final_currency: '{{ $transaction->final_currency }}',
                    received_amount: '{{ $transaction->received_amount ? number_format($transaction->received_amount/100, 2) : null }}',
                    exchange_rate: '{{ $transaction->exchange_rate }}',
                    sender: '{{ $transaction->sender_name }}',
                    message: '{{ $transaction->message }}'
                })"
            >
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
                        {{ $transaction->sender_account_id ?? __('Account Deleted') }}
                    @elseif($transaction->type == 'incoming')
                        {{ $transaction->recipient_account_id ?? __('Account Deleted') }}
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
                        {{ $transaction->sender_name }}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <x-input-error :messages="$errors->get('account')" class="mt-2" />
</div>
<div class="m-5 mb-6">
    {{ $transactions->links() }}
</div>

<!-- Modal HTML -->
<div id="transaction-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="modal-content bg-white p-6 rounded shadow-lg">
        <h2 class="text-xl font-semibold">Full Transaction Details</h2>
        <p>ID: <span id="modal-id"></span></p>
        <p>Type: <span id="modal-type"></span></p>
        <p>Status: <span id="modal-status"></span></p>
        <p>Date: <span id="modal-date"></span></p>
        <p>Sender's Account: <span id="modal-sender_account"></span></p>
        <p>Original Currency: <span id="modal-orig_currency"></span></p>
        <p>Sent Amount: <span id="modal-sent_amount"></span></p>
        <p>Final Currency: <span id="modal-final_currency"></span></p>
        <p>Received Amount: <span id="modal-received_amount"></span></p>
        <p>Exchange Rate: <span id="modal-exchange_rate"></span></p>
        <p>Sender: <span id="modal-sender"></span></p>
        <p>Message: <span id="modal-message"></span></p>
        <button onclick="closeModal()" class="mt-4 px-4 py-2 bg-yellow-500 text-white rounded">
            Close
        </button>
    </div>
</div>

<script>
    function openTransactionModal(data) {
        document.getElementById('modal-id').textContent = data.id;
        document.getElementById('modal-type').textContent = data.type;
        document.getElementById('modal-status').textContent = data.status;
        document.getElementById('modal-date').textContent = data.created_at;
        document.getElementById('modal-sender_account').textContent = data.sender_account;
        document.getElementById('modal-orig_currency').textContent = data.orig_currency;
        document.getElementById('modal-sent_amount').textContent = data.sent_amount;
        document.getElementById('modal-final_currency').textContent = data.final_currency;
        document.getElementById('modal-received_amount').textContent = data.received_amount;
        document.getElementById('modal-exchange_rate').textContent = data.exchange_rate;
        document.getElementById('modal-sender').textContent = data.sender;
        document.getElementById('modal-message').textContent = data.message;
        document.getElementById('transaction-modal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('transaction-modal').classList.add('hidden');
    }
</script>
