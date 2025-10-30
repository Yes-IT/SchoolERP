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
        Schema::table('attendances', function (Blueprint $table) {
            //
            $table->foreignId('year_status_id')->nullable()->constrained('year_status')->after('section_id');
            $table->foreignId('semester_id')->nullable()->constrained('semesters')->after('year_status_id');
            $table->enum('is_approved', ['0', '1'])->nullable()->after('semester_id');
            $table->foreignId('approved_by')->nullable()->constrained('staff')->after('is_approved');
            $table->timestamp('approved_date')->nullable()->after('approved_by');
            $table->timestamp('late_time')->nullable()->after('approved_date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            //
            $table->dropForeign(['year_status_id']);
            $table->dropForeign(['semester_id']);
            $table->dropForeign(['approved_by']);

            // Then drop the columns
            $table->dropColumn([
                'year_status_id',
                'semester_id',
                'is_approved',
                'approved_by',
                'approved_date',
                'late_time',
            ]);
        });
    }
};
