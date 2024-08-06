<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function portfolios(): hasMany
    {
        return $this->hasMany(Portfolio::class, 'currency_name', 'name');
    }
    public function cryptoTransactions(): hasMany
    {
        return $this->hasMany(CryptoTransaction::class, 'name', 'name');
    }
}
