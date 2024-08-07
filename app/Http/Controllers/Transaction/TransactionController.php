<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTransaction;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\NoReturn;
use Ramsey\Uuid\Uuid;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sentTransactions = Auth::user()->sentTransactions;
        $receivedTransactions = Auth::user()->receivedTransactions;
        $mergedTransactions = $sentTransactions->merge($receivedTransactions);
        $mergedTransactionsSorted = $mergedTransactions->sortByDesc('created_at');

        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = $mergedTransactionsSorted->slice(($currentPage-1) * $perPage, $perPage)->values();
        $paginator = new LengthAwarePaginator(
            $currentItems,
            $mergedTransactionsSorted->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );
        return view('private.transactions.index', [
            'transactions' => $paginator,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ownAccounts = Auth::user()->accounts()->whereIn('type', Account::TRANSACT_TYPES)->get();
        $sharedAccounts = Auth::user()->sharedWithAccounts;
        $accounts = $ownAccounts->merge($sharedAccounts);
        $contacts = Auth::user()->contacts;

        return view('private.transactions.create', [
            'accounts' => $accounts,
            'contacts' => $contacts,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[NoReturn] public function store(Request $request)
    {
        //validate
        $request->validate([
            'amount' => ['required', 'numeric'],
            'from_account' => ['required', 'exists:accounts,id'],
            'receiver_account' => ['required', 'exists:accounts,id'],
            'message' => ['max:250'],
        ]);
        $senderAccount = Account::where('id', $request->from_account)->first();
        $recipientAccount = Account::where('id', $request->receiver_account)->first();
        $recipient = User::where('id', $recipientAccount->user_id)->first();
        //translate to cents
        $sentAmount = $request->amount*100;
        //check if enough funds on the selected senders account
        if ($sentAmount > $senderAccount->balance){
            return redirect('/transactions/create')
                ->with('error', "Insufficient balance for such operation on the selected senders account");
        }
        //stage the OUT transaction record in database
        $transaction = Transaction::create([
            'id' => Uuid::uuid4(),
            'related_transaction_id' => null,
            'sender_id' => Auth::id(),
            'sender_account_id' => $request->from_account,
            'sender_name' => Auth::user()->first_name . " " . Auth::user()->last_name,
            'sender_email' => Auth::user()->email,
            'recipient_id' => $recipient->id,
            'recipient_account_id' => $recipientAccount->id,
            'recipient_name' => $recipient->first_name . " " . $recipient->last_name,
            'type' => 'outgoing',
            'status' => 'sent',
            'status_description' => null,
            'message' => $request->message ?? null,
            'product' => 'local',
            'orig_currency' => $senderAccount->currency,
            'final_currency' => $recipientAccount->currency,
            'exchange_rate' => null,
            'sent_amount' => $sentAmount,
            'received_amount' => null,
        ]);
        //place the job
        ProcessTransaction::dispatch($transaction->id);
        return redirect('/transactions')->with('success', 'Transaction sent successfully');
    }
}
