<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')
                ->primary();
            $table->uuid('related_transaction_id')
                ->nullable();
            $table->foreignIdFor(User::class, 'sender_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignIdFor(Account::class, 'sender_account_id')
                ->nullable()
                ->constrained('accounts')
                ->nullOnDelete();
            $table->string('sender_name');
            $table->string('sender_email');
            $table->foreignIdFor(User::class, 'recipient_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignIdFor(Account::class, 'recipient_account_id')
                ->nullable()
                ->constrained('accounts')
                ->nullOnDelete();
            $table->string('recipient_name');
            $table->string('type');
            $table->string('status');
            $table->string('status_description')
                ->nullable();
            $table->string('message')
                ->nullable();
            $table->string('product')
                ->nullable();
            $table->string('orig_currency');
            $table->string('final_currency');
            $table->string('exchange_rate')
                ->nullable();
            $table->string('sent_amount');
            $table->string('received_amount')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
