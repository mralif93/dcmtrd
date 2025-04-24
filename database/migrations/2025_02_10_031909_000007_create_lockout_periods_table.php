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
        Schema::create('lockout_periods', function (Blueprint $table) {
            $table->id();

            // foreign key to the redemptions table
            $table->foreignId('redemption_id')->constrained('redemptions')->onDelete('cascade');

            // lockout period details
            $table->date('start_date');
            $table->date('end_date');

            // default information
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lockout_periods');
    }
};