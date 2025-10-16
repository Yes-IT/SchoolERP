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
        Schema::create('applicant_parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants');
            $table->foreignId('parent_id')->constrained('parent_guardians');
            $table->enum('relation_type', ['father', 'mother', 'guardian'])->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('zip_code', 50)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('marital_status', 100)->nullable();
            $table->text('marital_comment')->nullable();
            $table->string('home_phone', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_parents');
    }
};
