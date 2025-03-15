<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('words', function (Blueprint $table) {
          $table->string('slug')->default('temp-slug')->after('word');
        });

        // giving value to the past words.
        $words = \App\Models\Word::all();
        foreach ($words as $word) {
            $word->slug = \Illuminate\Support\Str::slug($word->word);
            $word->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
