<?php

namespace App\Providers;

use App\Events\TransactionReceived;
use App\Listeners\SendTransactionConfirmation;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TransactionReceived::class => [
            SendTransactionConfirmation::class,
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
