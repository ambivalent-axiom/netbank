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
    public function investmentAccount(): hasOne
    {
        return $this->hasOne(Account::class, 'id', 'id');
    }
    public function cryptoTransactions(): HasMany
    {
        return $this->hasMany(CryptoTransaction::class, 'portfolio', 'id');
    }
    public function currencies(): HasMany
    {
        return $this->hasMany(Currency::class, 'name', 'currency_name');
    }
    public function profitUSD(): float
    {
        return $this->amount *= $this->currentRate();
    }
    public function investedUSD(): float
    {
        return $this->cryptoTransactions()
            ->where([
                'symbol' => $this->symbol,
                'name' => $this->currency_name
            ])
            ->where('created_at', '>', $this->created_at->subSeconds(10))
            ->sum('amount_USD')/100;
    }
    public function currentRate(): float
    {
        return $this->currencies()->firstWhere([
            'symbol' => $this->symbol,
            'name' => $this->currency_name
        ])->rate;
    }
    public function avgRate(): float
    {
        return $this->cryptoTransactions()
            ->where([
                'symbol' => $this->symbol,
                'name' => $this->currency_name
            ])
            ->where('created_at', '>', $this->created_at->subSeconds(10))
            ->avg('rate');
    }
    public function profitPercent(): float
    {
        $currentRate = $this->currentRate();
        $avgRate = $this->avgRate();
        return (($currentRate - $avgRate) / $avgRate) * 100;
    }
    public function cryptoLogo(): string
    {
        return $this->currencies()->firstWhere([
            'symbol' => $this->symbol,
            'name' => $this->currency_name
        ])->logo;
    }
}
