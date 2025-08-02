<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
     {
         Schema::table('student_profiles', function (Blueprint $table) {
             $table->boolean('is_child')->default(false)->after('daily_study_time');
         });
     }

     public function down()
     {
         Schema::table('student_profiles', function (Blueprint $table) {
             $table->dropColumn('is_child');
         });
     }
};
