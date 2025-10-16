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
        Schema::table('notice_boards', function (Blueprint $table) {
            //
            $table->string('target_type')->nullable()->after('visible_to'); // 'class', 'student', 'department', etc.
            $table->unsignedBigInteger('target_id')->nullable()->after('target_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notice_boards', function (Blueprint $table) {
            //
            $table->dropColumn('target_type');
            $table->dropColumn('target_id');
        });
    }
};
