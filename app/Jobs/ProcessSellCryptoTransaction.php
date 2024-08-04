<?php

namespace App\Jobs;

use App\Models\Account;
use App\Models\CryptoTransaction;
use App\Models\Portfolio;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSellCryptoTransaction implements ShouldQueue
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
            ['id', '=', $cryptoTransaction->portfolio],
            ['symbol', '=', $cryptoTransaction->symbol],
            ['currency_name', '=', $cryptoTransaction->name],
        ])->first();
        $investmentAccount = Account::where('portfolio_id', $cryptoTransaction->portfolio)->first();

        try {
            $portfolio->amount -= $cryptoTransaction->amount_crypto;
            $portfolio->save();
        } catch (Exception) {
            throw new Exception("Portfolio update error");
        }

        try {
            $investmentAccount->balance += $cryptoTransaction->amount_USD;
            $investmentAccount->save();
        } catch (Exception) {
            throw new Exception('Failed to deposit on Investment account.');
        }

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
