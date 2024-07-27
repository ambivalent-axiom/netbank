<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'id' => 'string'
    ];
    protected $guarded = [];

    public function user(): BelongsTo //sender
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
    public function recipient(): BelongsTo //receiver
    {
        return $this->belongsTo(User::class, 'recipient_id', 'id');
    }
    public function senderAccount(): BelongsTo //sender account
    {
        return $this->belongsTo(Account::class, 'sender_account_id', 'id');
    }
    public function recipientAccount(): BelongsTo //receiver account
    {
        return $this->belongsTo(Account::class, 'recipient_account_id', 'id');
    }
}
