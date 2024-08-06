<?php

namespace App\Jobs;

use App\Models\Account;
use App\Models\CryptoTransaction;
use App\Models\Portfolio;
use App\Models\Transaction;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessBuyCryptoTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $cryptoTransactionId;

    /**
     * Create a new job instance.
     */
    public function __construct($cryptoTransactionId)
    {
        $this->cryptoTransactionId = $cryptoTransactionId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $cryptoTransaction = CryptoTransaction::where('id', $this->cryptoTransactionId)
            ->first();
        $portfolio = Portfolio::where([
            ['portfolio_id', '=', $cryptoTransaction->portfolio],
            ['symbol', '=', $cryptoTransaction->symbol],
            ['currency_name', '=', $cryptoTransaction->name],
        ])->get();

        $investmentAccount = Account::where('portfolio_id', $cryptoTransaction->portfolio)->first();

        if ( count($portfolio) === 0 )
        {
            $amount = $cryptoTransaction->amount_crypto;
        }
        if ( count($portfolio) === 1 )
        {
            $amount = $portfolio->first()->amount + $cryptoTransaction->amount_crypto;
        }
        if ( count($portfolio) > 1 )
        {
            throw new Exception("Portfolio records more then one per currency");
        }
        $balanceOld = $investmentAccount->balance;
        try {
            $investmentAccount->balance -= $cryptoTransaction->amount_USD;
            $investmentAccount->save();
        } catch (Exception $exception) {
            throw new Exception('Failed to charge Investment account.');
        }
        if ($investmentAccount->balance == $balanceOld)
        {
            throw new Exception('Failed to charge Investment account.');
        }


        Portfolio::updateOrCreate(
            [
                'user_id' => $cryptoTransaction->user_id,
                'symbol' => $cryptoTransaction->symbol,
                'currency_name' => $cryptoTransaction->name,
            ],
            [
                'portfolio_id' => $cryptoTransaction->portfolio,
                'amount' => $amount,
            ]
        );
        $cryptoTransaction->status = 'completed';
        $cryptoTransaction->save();


    }
    public function failed()
    {
        $cryptoTransaction = CryptoTransaction::where('id', $this->cryptoTransactionId)
            ->first();
        $cryptoTransaction->status = 'failed';
        $cryptoTransaction->save();
    }
}
