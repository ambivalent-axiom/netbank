<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $casts = [
        'id' => 'string'
    ];
    protected $guarded = [];

    public function user(): BelongsTo //sender
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function senderAccount(): BelongsTo //sender account
    {
        return $this->belongsTo(Account::class, 'sender_account_id');
    }
    public function receiverAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'receiver_account_id');
    }
}
