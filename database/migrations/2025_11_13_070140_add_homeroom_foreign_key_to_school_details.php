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
        Schema::table('school_details', function (Blueprint $table) {
            $table->foreignId('homeroom_id')->constrained('homeroom_class');
            $table->foreignId('division_id')->constrained('divisions');
            $table->foreignId('group_id')->constrained('group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_details', function (Blueprint $table) {
            $table->dropForeign(['homeroom_id']);
            $table->dropForeign(['division_id']);
            $table->dropForeign(['group_id']);
        });
    }
};
