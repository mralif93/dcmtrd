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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('portfolio_name');
            $table->string('annual_report')->nullable();
            $table->string('trust_deed_document')->nullable();
            $table->string('insurance_document')->nullable();
            $table->string('valuation_report')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes for better performance
            $table->index('portfolio_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
