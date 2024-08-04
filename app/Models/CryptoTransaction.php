<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CryptoTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'id', 'portfolio');
    }
}
