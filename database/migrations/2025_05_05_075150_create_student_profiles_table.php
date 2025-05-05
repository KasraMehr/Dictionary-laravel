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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bio')->nullable();
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('country')->nullable();
            $table->string('timezone')->nullable();
            $table->json('learning_languages')->nullable(); // زبان‌هایی که می‌خواهد یاد بگیرد
            $table->json('known_languages')->nullable(); // زبان‌هایی که بلد است
            $table->string('education_level')->nullable();
            $table->string('occupation')->nullable();
            $table->text('learning_goals')->nullable();
            $table->string('preferred_learning_style')->nullable();
            $table->integer('daily_study_time')->nullable(); // دقیقه
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
