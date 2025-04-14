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
        Schema::create('course_user', function (Blueprint $table) {
          $table->id();
          $table->foreignId('course_id')->constrained()->onDelete('cascade');
          $table->foreignId('user_id')->constrained()->onDelete('cascade');
          $table->timestamp('enrolled_at')->nullable();
          $table->unsignedTinyInteger('progress')->default(0)->after('user_id');
          $table->timestamp('completed_at')->nullable()->after('progress');
          $table->unsignedTinyInteger('rating')->nullable()->after('completed_at');
          $table->text('review')->nullable()->after('rating');
          $table->boolean('is_favorite')->default(false)->after('review');
          $table->timestamp('last_accessed_at')->nullable()->after('is_favorite');
          $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending')->after('is_favorite');
          $table->string('transaction_id')->nullable()->after('payment_status'); // شناسه تراکنش
          $table->timestamp('expires_at')->nullable()->after('last_accessed_at');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_user');
    }
};
