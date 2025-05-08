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
      Schema::create('saved_words', function (Blueprint $table) {
          $table->id();
          $table->foreignId('user_id')->constrained()->onDelete('cascade');
          $table->foreignId('word_id')->constrained()->onDelete('cascade');
          $table->integer('review_count')->default(0);
          $table->timestamp('last_reviewed_at')->nullable();
          $table->timestamp('next_review_at')->nullable();
          $table->float('ease_factor')->default(2.5); // برای الگوریتم تکرار فضایی
          $table->integer('interval')->default(1);
          $table->timestamps();

          $table->unique(['user_id', 'word_id']);
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_words');
    }
};
