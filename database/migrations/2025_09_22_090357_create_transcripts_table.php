<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transcripts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->comment('Student ID reference');
            $table->string('destination')->comment('Transcript destination');
            $table->enum('payment_requirement', ['yes', 'no'])->default('no')->comment('Whether payment is required');
            
            $table->tinyInteger('payment_status')
                  ->default(0)
                  ->comment('0 = Pending, 1 = Paid, 2 = Failed');
            
            $table->string('payment_receipt_link')->nullable()->comment('Link to payment receipt if available');
            
            $table->tinyInteger('status')
                  ->default(0)
                  ->comment('0 = Pending, 1 = Approved, 2 = Rejected');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transcripts');
    }
};
