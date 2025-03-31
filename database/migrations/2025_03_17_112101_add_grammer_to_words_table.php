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
        Schema::table('words', function (Blueprint $table) {
          $table->enum('grammar', [
            '-', 'noun', 'pronoun', 'verb', 'adjective', 'adverb', 'preposition', 'conjunction',
            'interjection', 'article', 'determiner', 'numeral', 'auxiliary verb',
            'modal verb', 'participle', 'gerund', 'infinitive', 'possessive pronoun',
            'relative pronoun','demonstrative pronoun','reflexive pronoun','reciprocal pronoun','intensive pronoun'
            ])->default('-')->after('word');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropColumn('grammar');
        });
    }
};
