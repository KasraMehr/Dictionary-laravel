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
        Schema::create('course_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('skills');
            $table->json('content');
            $table->foreignId('quiz_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('order')->default(0);
            $table->unsignedInteger('duration_minutes')->default(0)->after('order'); // مدت زمان درس
            $table->boolean('is_preview')->default(false)->after('duration_minutes'); // آیا پیش‌نمایش رایگان است
            $table->string('video_url')->nullable()->after('content'); // لینک ویدیو
            $table->string('thumbnail')->nullable()->after('video_url'); // تصویر درس
            $table->json('attachments')->nullable()->after('thumbnail'); // فایل‌های ضمیمه
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lessons');
    }
};
