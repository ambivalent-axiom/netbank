<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'type',
        'company'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'user_id')->where('type', '!=', 'deleted');
    }
    public function sharedAccounts(): HasMany
    {
        return $this->hasMany(SharedAccount::class, 'user_id')->where('type', '!=', 'deleted');
    }
    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_contacts', 'user_id', 'contact_user_id');
    }
    public function sharedWithAccounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class, 'shared_accounts', 'shared_user_id', 'account_id')
            ->where('type', '!=', 'deleted');
    }
    public function receivedTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'recipient_id')->where('type', 'incoming');
    }
    public function sentTransactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'sender_id')->where('type', 'outgoing');
    }
    public function cryptoTransactions(): HasMany
    {
        return $this->hasMany(CryptoTransaction::class, 'user_id', 'id');
    }
    public function userMessages(): HasMany
    {
        return $this->hasMany(UserMessage::class, 'user_id', 'id')->where('status', 'new');
    }
}
