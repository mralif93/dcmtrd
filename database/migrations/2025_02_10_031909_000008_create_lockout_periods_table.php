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

            // Foreign Key
            $table->foreignId('redemption_id')->constrained('redemptions')->onDelete('cascade');

            // Date Range
            $table->date('start_date');
            $table->date('end_date');

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index('redemption_id');
            $table->index(['start_date', 'end_date']);
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