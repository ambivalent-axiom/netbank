<?php

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
        Schema::create('crypto_transaction', function (Blueprint $table) {
            $table->id();
            $table->uuid('portfolio');
            $table->integer('user_id');
            $table->string('symbol');
            $table->string('type');
            $table->float('rate');
            $table->integer('amount_USD');
            $table->float('amount_crypto');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crypto_transaction');
    }
};
