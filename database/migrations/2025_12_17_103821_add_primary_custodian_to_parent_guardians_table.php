<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('parent_guardians', function (Blueprint $table) {
            $table->enum('primary_custodian', [
                'father',
                'mother',
                'both',
                'legal_guardian'
            ])->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('parent_guardians', function (Blueprint $table) {
            $table->dropColumn('primary_custodian');
        });
    }
};
