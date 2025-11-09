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
        Schema::table('applicant_parents', function (Blueprint $table) {
            //
            $table->string('father_title')->nullable()->after('relation_type');
            $table->string('father_name')->nullable()->after('father_title');
            $table->string('father_last_name')->nullable()->after('father_name');

            $table->string('father_email')->nullable()->after('father_name');
            $table->string('father_cell')->nullable()->after('father_email');
            $table->string('father_occupation')->nullable()->after('father_cell');

            $table->string('mother_title')->nullable()->after('father_occupation');
            $table->string('mother_name')->nullable()->after('mother_title');
            $table->string('mother_email')->nullable()->after('mother_name');
            $table->string('mother_cell')->nullable()->after('mother_email');
            $table->string('mother_occupation')->nullable()->after('mother_cell');
            $table->string('maiden_name')->nullable()->after('mother_occupation');

            $table->string('additional_phone_no')->nullable()->after('maiden_name');
            $table->text('additional_email_addresses')->nullable()->after('additional_phone_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicant_parents', function (Blueprint $table) {
            //
            $table->dropColumn('father_title');
            $table->dropColumn('father_name');
            $table->dropColumn('father_last_name');
            $table->dropColumn('father_email');
            $table->dropColumn('father_cell');
            $table->dropColumn('father_occupation');
            $table->dropColumn('mother_title');
            $table->dropColumn('mother_name');
            $table->dropColumn('mother_email');
            $table->dropColumn('mother_cell');
            $table->dropColumn('mother_occupation');
            $table->dropColumn('maiden_name');
            $table->dropColumn('additional_phone_no');
            $table->dropColumn('additional_email_addresses');
        });
    }
};
