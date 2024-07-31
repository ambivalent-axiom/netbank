<?php

namespace App\Jobs;

use AllowDynamicProperties;
use App\Models\Account;
use App\Models\Currency;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Log;

#[AllowDynamicProperties] class ProcessTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $transactionId;

    /**
     * Create a new job instance.
     */
    public function __construct($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $transactionOut = Transaction::find($this->transactionId);
        $sendersAccount = Account::find($transactionOut->sender_account_id);
        $recipientAccount = Account::find($transactionOut->recipient_account_id);
        $sender = User::find($transactionOut->sender_id);
        $recipient = User::find($transactionOut->recipient_id);
        //check if currency exchange necessary
        if ($transactionOut->orig_currency != $transactionOut->final_currency) {
            $senderCurrencyRateToEur = Currency::where('symbol', $transactionOut->orig_currency)->first()->rate;
            $recipientCurrencyRateToEur = Currency::where('symbol', $transactionOut->final_currency)->first()->rate;
            $amountToReceive = round(($transactionOut->sent_amount*($recipientCurrencyRateToEur/$senderCurrencyRateToEur)));
            if($sendersAccount->currency == 'EUR' || $recipientAccount->currency == 'EUR') {
                $amountToReceive = round(($transactionOut->sent_amount*($senderCurrencyRateToEur/$recipientCurrencyRateToEur)));
            }
        }
        //TODO do any other necessary validations
        //stage the In transaction record in database
        $transactionIn = Transaction::create([
            'id' => Uuid::uuid4(),
            'related_transaction_id' => $transactionOut->id,
            'sender_id' => $sender->id,
            'sender_account_id' => $sendersAccount->id,
            'sender_name' => $sender->first_name . " " . $sender->last_name,
            'sender_email' => $sender->email,
            'recipient_id' => $recipient->id,
            'recipient_account_id' => $recipientAccount->id,
            'recipient_name' => $recipient->first_name . " " . $recipient->last_name,
            'type' => 'incoming',
            'status' => 'received',
            'status_description' => 'received with no errors',
            'message' => $transactionOut->message ?? null,
            'product' => 'local',
            'orig_currency' => $sendersAccount->currency,
            'final_currency' => $recipientAccount->currency,
            'exchange_rate' => $exchangeRate ?? null,
            'sent_amount' => $transactionOut->sent_amount,
            'received_amount' => $amountToReceive ?? $transactionOut->sent_amount,
        ]);

        //set out/in transaction status as processed
        $transactionOut->related_transaction_id = $transactionIn->id;
        $transactionOut->status = 'completed';
        $transactionOut->exchange_rate = $exchangeRate ?? null;
        $transactionOut->received_amount = $transactionIn->received_amount;
        $transactionOut->save();

        //withdraw the amount from sender
        try {
            $sendersAccount->balance -= $transactionOut->sent_amount;
            $sendersAccount->save();
        } catch (\Exception $e) {
            throw $e;
        }

        // place funds on receivers account
        try {
            $recipientAccount->balance += $amountToReceive ?? $transactionIn->received_amount;
            $recipientAccount->save();
        } catch (\Exception $e) {
            throw $e;
        }

        //TODO job must return funds to sender and set transaction status as failed if it fails for any reason
    }
    public function failed()
    {
        $transactionOut = Transaction::find($this->transactionId);
        $transactionOut->status = 'failed';
        $transactionOut->status_description = 'transaction failed';
        $transactionOut->save();
    }
}
