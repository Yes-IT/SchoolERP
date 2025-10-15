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
            $table->boolean('composite_average')->default(false)->after('year_status_id');
            $table->string('composite_class_1')->nullable()->after('composite_average');
            $table->string('composite_class_2')->nullable()->after('composite_class_1');
            $table->string('composite_class_1_weight')->nullable()->after('composite_class_2');
            $table->string('composite_class_2_weight')->nullable()->after('composite_class_1_weight');
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
            $table->dropColumn('composite_average');
            $table->dropColumn('composite_class_1');
            $table->dropColumn('composite_class_2');
            $table->dropColumn('composite_class_1_weight');
            $table->dropColumn('composite_class_2_weight');
        });
    }
};
