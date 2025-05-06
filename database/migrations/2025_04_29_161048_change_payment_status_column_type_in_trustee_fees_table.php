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
        Schema::table('trustee_fees', function (Blueprint $table) {
            $table->string('payment_status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trustee_fees', function (Blueprint $table) {
            $table->date('payment_status')->nullable()->change();
        });
    }
};
