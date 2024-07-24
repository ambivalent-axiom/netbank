<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SharedAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'shared_user_id',
        'account_id'
    ];
    public function sharedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'shared_user_id');
    }
}
