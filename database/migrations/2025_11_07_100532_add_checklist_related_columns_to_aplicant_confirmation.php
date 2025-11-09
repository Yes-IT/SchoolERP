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
        Schema::table('aplicant_confirmation', function (Blueprint $table) {
            //
            $table->string('reference')->nullable()->after('card_holder_name');
            $table->string('pictures')->nullable()->after('reference');
            $table->boolean('transcript_hebrew')->default(false)->nullable()->after('pictures');
            $table->boolean('transcript_english')->default(false)->nullable()->after('transcript_hebrew');




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aplicant_confirmation', function (Blueprint $table) {
            $table->dropColumn('reference');
            $table->dropColumn('pictures');
            $table->dropColumn('transcript_hebrew');
            $table->dropColumn('transcript_english');
        });
    }
};
