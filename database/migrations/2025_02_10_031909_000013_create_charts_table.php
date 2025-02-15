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
        Schema::create('charts', function (Blueprint $table) {
            $table->id();

            // Foreign Key
            $table->foreignId('bond_id')->constrained()->onDelete('cascade');

            $table->string('chart_type', 50);
            $table->json('chart_data');
            $table->date('period_from');
            $table->date('period_to');

            // Timestamp
            $table->timestamps();

            // Indexes for common queries
            $table->index('chart_type');
            $table->index(['period_from', 'period_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charts');
    }
};
