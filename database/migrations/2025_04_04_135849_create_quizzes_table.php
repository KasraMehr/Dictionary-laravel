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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['lesson', 'final', 'placement'])->default('lesson');
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->string('level')->nullable();
            $table->integer('time_limit')->default(0); // in minutes
            $table->integer('pass_score')->default(70);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
