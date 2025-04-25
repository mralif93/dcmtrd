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
        Schema::table('facility_informations', function (Blueprint $table) {
            $table->boolean('is_redeemed')->default(false)->after('availability_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facility_informations', function (Blueprint $table) {
            $table->dropColumn('is_redeemed');
        });
    }
};
