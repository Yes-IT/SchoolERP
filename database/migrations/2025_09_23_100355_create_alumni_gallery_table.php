<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumniGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumni_gallery', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('filename'); // Original filename (e.g., "myphoto.jpg")
            $table->string('encoded_name')->unique(); // Unique encoded name (e.g., "hashed_name.jpg")
            $table->string('path'); // File path (e.g., "storage/alumni_gallery/myphoto.jpg")
            $table->string('type'); // Media type (e.g., 'image', 'video', 'mov')
            $table->unsignedBigInteger('size')->nullable(); // File size in bytes
            $table->string('title')->nullable(); // Optional title
            $table->text('description')->nullable(); // Optional description
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumni_gallery');
    }
}