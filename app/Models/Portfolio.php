<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Portfolio extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    protected $casts = [
        'id' => 'string'
    ];
    protected $with = ['currencies', 'cryptoTransactions'];
    public function investmentAccount(): hasOne
    {
        return $this->hasOne(Account::class);
    }
    public function cryptoTransactions(): HasMany
    {
        return $this->hasMany(CryptoTransaction::class, 'portfolio', 'portfolio_id');
    }
    public function currencies(): HasMany
    {
        return $this->hasMany(Currency::class, 'name', 'currency_name');
    }
    public function withProfitUSD(): float
    {
        return $this->amount * $this->currencies[0]->rate; //exchange back to current USD rate
    }
    public function profitUSD(): float
    {
        return ($this->amount * $this->currencies[0]->rate)-$this->investedUSD(); //exchange back to current USD rate
    }
    public function investedUSD(): float
    {
        $buy = $this->cryptoTransactions->filter(function ($transaction) {
            return $transaction->symbol == $this->symbol &&
                $transaction->name == $this->currency_name &&
                $transaction->type == 'buy' &&
                $transaction->created_at->gt($this->created_at->subSeconds(10));
        });
        $sell = $this->cryptoTransactions->filter(function ($transaction) {
            return $transaction->symbol == $this->symbol &&
                $transaction->name == $this->currency_name &&
                $transaction->type == 'sell' &&
                $transaction->created_at->gt($this->created_at->subSeconds(10));
        });
        return ($buy->sum('amount_USD') - $sell->sum('amount_USD'))/100;
    }
    public function avgRate(): float
    {
        $transactionsFiltered = $this->cryptoTransactions->filter(function ($transaction) {
            return $transaction->symbol == $this->symbol &&
                $transaction->name == $this->currency_name &&
                $transaction->created_at->gt($this->created_at->subSeconds(10));
        });
        return $transactionsFiltered->avg('rate');
    }
    public function profitPercent(): float
    {
        $avgRate = $this->avgRate();
        return (($this->currencies[0]->rate - $avgRate) / $avgRate) * 100;
    }
}
