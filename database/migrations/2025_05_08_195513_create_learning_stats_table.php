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
      Schema::create('learning_stats', function (Blueprint $table) {
          $table->id();
          $table->foreignId('user_id')->constrained()->onDelete('cascade');
          $table->integer('learned_words_count')->default(0);
          $table->integer('active_days_streak')->default(0);
          $table->integer('total_study_minutes')->default(0);
          $table->integer('rank')->nullable();
          $table->date('last_studied_at')->nullable();
          $table->json('weekly_progress')->nullable();
          $table->json('daily_goals')->nullable();
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_stats');
    }
};
