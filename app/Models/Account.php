<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Account extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    protected $casts = [
        'id' => 'string'
    ];
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function transactionsIn(): HasMany
    {
        return $this->hasMany(Transaction::class, 'recipient_account_id', 'id')->where('type', 'incoming');
    }
    public function transactionsOut(): HasMany
    {
        return $this->hasMany(Transaction::class, 'sender_account_id', 'id')->where('type', 'outgoing');
    }
    public function portfolio(): HasOne
    {
        return $this->hasOne(Portfolio::class, 'portfolio_id');//TODO implement portfolio class
    }
}

