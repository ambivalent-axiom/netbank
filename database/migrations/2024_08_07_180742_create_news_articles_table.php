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
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('title');
            $table->string('author');
            $table->string('url');
            $table->text('description');
            $table->text('content');
            $table->string('image');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->unique(['source', 'title']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};
