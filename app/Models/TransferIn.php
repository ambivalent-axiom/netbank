<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferIn extends Model
{
    use HasFactory;
    protected $casts = [
        'id' => 'string'
    ];
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id'); //receiver
    }
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'recipient_account_id'); //receiver account
    }
    public function transferOut(): BelongsTo
    {
        return $this->belongsTo(TransferOut::class, 'transfer_out_id');
    }
}
