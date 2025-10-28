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
        Schema::table('examination_results', function (Blueprint $table) {
            //
            $table->foreignId('year_status_id')->constrained('year_status')->after('session_id');
            $table->foreignId('semester_id')->constrained('semesters')->after('year_status_id');
            $table->foreignId('subject_id')->constrained('subjects')->after('semester_id');

            $table->integer('marks_achieved')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('examination_results', function (Blueprint $table) {
            
            $table->dropForeign(['year_status_id']);
            $table->dropColumn('year_status_id');

          
            $table->dropForeign(['semester_id']);
            $table->dropColumn('semester_id');

            $table->dropForeign(['subject_id']);
            $table->dropColumn('subject_id');

            $table->dropColumn('marks_achieved');
        });
    }
};
