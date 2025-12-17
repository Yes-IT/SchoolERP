<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('parent_guardians', function (Blueprint $table) {
            $table->string('marital_comment', 255)
                  ->nullable()
                  ->after('marital_status');
        });
    }

    public function down(): void
    {
        Schema::table('parent_guardians', function (Blueprint $table) {
            $table->dropColumn('marital_comment');
        });
    }
};
