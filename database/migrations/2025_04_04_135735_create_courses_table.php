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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('trailer_url')->nullable();
            $table->text('description')->nullable();
            $table->string('level'); // A1, B2, etc
            $table->string('topic')->nullable();
            $table->boolean('is_free')->default(true);
            $table->string('thumbnail')->nullable();
            $table->string('language')->default('en');
            $table->unsignedInteger('duration_minutes')->default(0)->after('language');
            $table->unsignedInteger('lessons_count')->default(0)->after('duration_minutes');
            $table->unsignedInteger('students_count')->default(0)->after('lessons_count');
            $table->decimal('price', 10, 2)->nullable()->after('is_free');
            $table->string('certificate_template')->nullable()->after('price');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
