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
        Schema::create('recorded_classes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->string('speaker')->nullable();
            $table->unsignedBigInteger('class_id'); // FK to classes
            $table->date('date')->nullable();
            $table->string('filename')->nullable();
            $table->string('coded_name')->nullable();
            $table->string('path')->nullable();
            $table->enum('type', ['audio', 'video'])->default('video');
            $table->bigInteger('size')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recorded_classes');
    }
};
