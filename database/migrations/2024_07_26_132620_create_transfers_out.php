<?php

use App\Models\Account;
use App\Models\TransferIn;
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
        Schema::create('transfers_out', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->foreignIdFor(TransferIn::class, 'transfer_in_id')->nullable();
            $table->string('message')->nullable();
            $table->string('type')->nullable();
            $table->string('currency');
            $table->string('amount');
            $table->foreignIdFor(User::class, 'sender_id')->constrained();
            $table->foreignIdFor(Account::class, 'sender_account_id')->constrained();
            $table->string('sender_first_name');
            $table->string('sender_last_name');
            $table->string('sender_email');
            $table->string('recipient_first_name');
            $table->string('recipient_last_name');
            $table->foreignIdFor(User::class, 'recipient_id')->constrained();
            $table->foreignIdFor(Account::class, 'recipient_account_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers_out');
    }
};
