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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Ramsey\Uuid\Uuid;

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

        //fetch exchange rates from cache and parse
        $xml = simplexml_load_string(Cache::get('exchange_rates'));
        $currencies = collect();
        foreach ($xml->Currencies->Currency as $currency) {
            $currencies->add(new Currency((string) $currency->ID, (float) $currency->Rate));
        }
        $currentUsdRate = $currencies->where(function (Currency $currency) {
            return $currency->getId() == 'USD';
        });
        //check if currency exchange necessary
        if ($sendersAccount->currency != $recipientAccount->currency) {
            if ($recipientAccount->currency = 'USD')
            {
                $exchangeRate = $currentUsdRate->getRate();
            }
            if ($recipientAccount->currency = 'EUR')
            {
                $exchangeRate = 1/$currentUsdRate->getRate();
            }
            $amountToReceive = round($transactionOut->sent_amount*$exchangeRate);
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
            'message' => null,
            'product' => 'local',
            'orig_currency' => $sendersAccount->currency,
            'final_currency' => $recipientAccount->currency,
            'exchange_rate' => $exchangeRate ?? null,
            'sent_amount' => $transactionOut->sent_amount,
            'received_amount' => $amountToReceive ?? null,
        ]);

        //set out/in transaction status as processed
        $transactionOut->related_transaction_id = $transactionIn->id;
        $transactionOut->status = 'completed';
        $transactionOut->save();

        //withdraw the amount from sender
        $sendersAccount->balance -= $transactionOut->amount;
        $sendersAccount->save();

        // place funds on receivers account
        $recipientAccount->balance += $amountToReceive ?? $transactionOut->amount;
        $recipientAccount->save();
        //TODO job must return funds to sender and set transaction status as failed if it fails for any reason
    }
    public function failed()
    {
        $transactionOut = Transaction::find($this->transactionId);
        $transactionOut->status = 'failed';
        $transactionOut->status_description = 'failed because of laggy code';
        $transactionOut->save();
    }
}
