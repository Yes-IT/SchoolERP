<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->unsignedBigInteger('classes_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('year_status_id')->nullable();
            $table->unsignedBigInteger('semester_id')->nullable();

            $table->date('apply_date');
            $table->date('from_date');
            $table->date('to_date');

            $table->tinyInteger('is_approved')
                ->default(0)
                ->comment('0 = Pending, 1 = Approved, 2 = Rejected');

            $table->dateTime('approved_date')->nullable();

            $table->text('reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
