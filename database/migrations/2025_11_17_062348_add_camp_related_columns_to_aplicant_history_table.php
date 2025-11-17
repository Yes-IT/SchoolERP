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
        Schema::table('aplicant_history', function (Blueprint $table) {
            //
            $table->text('camp_names')->nullable()->after('school_grades');
            $table->text('camp_years')->nullable()->after('camp_names');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aplicant_history', function (Blueprint $table) {
            //
            $table->dropColumn(['camp_names', 'camp_years']);
        });
    }
};
