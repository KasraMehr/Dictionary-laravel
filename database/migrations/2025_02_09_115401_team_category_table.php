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
        Schema::create('team_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('team_id')->unsigned();
            $table->unsignedBiginteger('category_id')->unsigned();

            $table->foreign('team_id')->references('id')
                ->on('teams')->onDelete('cascade');
            $table->foreign('category_id')->references('id')
                ->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_category');
    }
};
