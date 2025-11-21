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
        Schema::create('exam_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('staff');
            $table->foreignId('exam_type_id')->constrained('exam_types');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->foreignId('room_id')->constrained('class_rooms');
            $table->foreignId('class_id')->constrained('classes');
            $table->date('exam_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration')->comment('Duration in minutes');
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_requests');
    }
};
