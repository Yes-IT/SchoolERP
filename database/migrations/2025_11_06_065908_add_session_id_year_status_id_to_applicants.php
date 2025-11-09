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
        Schema::table('applicants', function (Blueprint $table) {

        $table->foreignId('session_id')->nullable()->constrained('sessions')->after('custom_id');
        $table->foreignId('year_status_id')->nullable()->constrained('year_status')->after('session_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicants', function (Blueprint $table) {
            //
            $table->dropColumn('session_id');
            $table->dropColumn('year_status_id');
        });
    }
};
