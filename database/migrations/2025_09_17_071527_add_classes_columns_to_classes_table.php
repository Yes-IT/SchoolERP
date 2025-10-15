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
        Schema::table('classes', function (Blueprint $table) {
            //
            $table->string('identification_number')->nullable()->after('status');
            $table->foreignId('subject_id')->constrained('subjects')->after('identification_number');
            $table->foreignId('teacher_id')->constrained('staff')->after('subject_id');
            $table->foreignId('school_year_id')->constrained('school_years')->after('teacher_id');
            $table->foreignId('semester_id')->constrained('semesters')->after('school_year_id');
            $table->foreignId('year_status_id')->constrained('year_statuses')->after('semester_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classes', function (Blueprint $table) {
            //
            $table->dropColumn('identification_number');
            $table->dropColumn('subject_id');
            $table->dropColumn('teacher_id');
            $table->dropColumn('school_year_id');
            $table->dropColumn('semester_id');
            $table->dropColumn('year_status_id');
        });
    }
};
