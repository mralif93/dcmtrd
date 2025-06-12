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
        Schema::table('tenancy_letters', function (Blueprint $table) {
            $table->date('supplemental_letter_offer_date')->nullable()->after('letter_offer_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenancy_letters', function (Blueprint $table) {
            table->dropColumn('supplemental_letter_offer_date');
        });
    }
};
