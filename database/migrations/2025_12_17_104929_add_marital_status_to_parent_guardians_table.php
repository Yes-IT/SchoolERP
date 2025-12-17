<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('parent_guardians', function (Blueprint $table) {
            $table->enum('marital_status', [
                'married',
                'remarried',
                'widowed',
                'divorced',
                'separated'
            ])->nullable()->after('primary_custodian');
        });
    }

    public function down(): void
    {
        Schema::table('parent_guardians', function (Blueprint $table) {
            $table->dropColumn('marital_status');
        });
    }
};
