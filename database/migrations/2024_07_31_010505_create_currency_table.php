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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('symbol');
            $table->float('rate');
            $table->string('name')->nullable();
            $table->string('rank')->nullable();
            $table->string('percent_changed')->nullable();
            $table->timestamps();
            $table->unique(['symbol', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
