<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_check_list', function (Blueprint $table) {
            //
            $table->boolean('transcript_hebrew')->default(false);
            $table->boolean('transcript_english')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicant_check_list', function (Blueprint $table) {
            //
            $table->dropColumn('transcript_hebrew');
            $table->dropColumn('transcript_english');
        });
    }
};
