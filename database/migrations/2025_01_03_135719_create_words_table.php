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
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->string('meaning');
            $table->string('pronunciation')->nullable();
            $table->enum('level', ['A1', 'A2', 'B1', 'B2', 'C1', 'C2', '-'])->default('-')->after('word');
            $table->enum('grammar', [
                '-', 'noun', 'pronoun', 'verb', 'adjective', 'adverb', 'preposition', 'conjunction',
                'interjection', 'article', 'determiner', 'numeral', 'auxiliary verb',
                'modal verb', 'participle', 'gerund', 'infinitive', 'possessive pronoun',
                'relative pronoun','demonstrative pronoun','reflexive pronoun','reciprocal pronoun','intensive pronoun'
            ])->default('-');
            $table->string('voice')->nullable();
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->string('slug')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
