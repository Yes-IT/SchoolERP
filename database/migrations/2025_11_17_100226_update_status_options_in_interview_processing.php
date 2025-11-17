<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{Schema, DB};

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::statement("
            ALTER TABLE interview_processing 
            MODIFY COLUMN status TINYINT(1) 
            COMMENT '0:pending,1:approve,2:reject,3:accept,4:not_accept,5:priority_pending'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            ALTER TABLE interview_processing 
            MODIFY COLUMN status TINYINT(1) 
            COMMENT '0:pending,1:approve,2:reject'
        ");
    }
};
