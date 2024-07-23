<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Account extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'id' => 'string'
    ];
    public function portfolio(): HasOne
    {
        return $this->hasOne(Portfolio::class, 'portfolio_id');//TODO implement portfolio class
    }
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);//TODO implement transaction class
    }
}

