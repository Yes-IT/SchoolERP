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
        Schema::table('interview_processing', function (Blueprint $table) {
            //
            $table->tinyInteger('interview_state')->default(0)->comment('0=suspended, 1=active')->after('interview_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interview_processing', function (Blueprint $table) {
            $table->dropColumn('interview_state');
        });
    }
};
