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
        Schema::table('parent_guardians', function (Blueprint $table) {
            // Marital Status (required)
            $table->string('marital_status', 20)->after('additional_emails');

            // Address Details
            $table->text('address_line')->after('marital_status');              // Street address (required)
            $table->string('city', 100)->after('address_line');                 // Required
            $table->string('state', 100)->nullable()->after('city');
            $table->string('zip_code', 20)->nullable()->after('state');
            $table->string('country', 100)->after('zip_code');                  // Required
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parent_guardians', function (Blueprint $table) {
            $table->dropColumn([
                'marital_status',
                'address_line',
                'city',
                'state',
                'zip_code',
                'country'
            ]);
        });
    }
};