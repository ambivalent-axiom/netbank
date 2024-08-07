<?php

namespace App\Listeners;

use App\Events\TransactionReceived;
use App\Models\UserMessage;
use http\Message;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTransactionConfirmation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionReceived $event): void
    {
        $transaction = $event->transaction;
        UserMessage::create([
            'user_id' => $transaction->sender_id,
            'message' => $transaction->recipient_name . ' has received Your money transfer - ' . $transaction->message,
            'type' => 'confirmation',
            'from' => 'transactions',
            'status' => 'new',
        ]);
    }
}
