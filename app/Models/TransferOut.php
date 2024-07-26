<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferOut extends Model
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
    public function account(): BelongsTo //sender account
    {
        return $this->belongsTo(Account::class, 'sender_account_id');
    }
}
