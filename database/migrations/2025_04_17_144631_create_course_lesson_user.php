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
        Schema::create('course_lesson_user', function (Blueprint $table) {
          $table->id();
          $table->foreignId('user_id')->constrained()->onDelete('cascade');
          $table->foreignId('course_lesson_id')->constrained()->onDelete('cascade'); // foreign key به درس‌ها
          $table->boolean('completed')->default(false); // وضعیت تکمیل
          $table->unsignedTinyInteger('progress')->default(0); // پیشرفت درس (برای مثال درصد)
          $table->timestamp('started_at')->nullable(); // زمان شروع
          $table->timestamp('completed_at')->nullable(); // زمان تکمیل
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lesson_user');
    }
};
