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
    public function up(): void
    {
        DB::statement('ALTER TABLE applicants CHANGE `highschool(application)` `highschool_application` VARCHAR(255)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down(): void
    {
        DB::statement('ALTER TABLE applicants CHANGE `highschool_application` `highschool(application)` VARCHAR(255)');
    }
};
