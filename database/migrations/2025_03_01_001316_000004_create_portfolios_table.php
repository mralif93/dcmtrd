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

            // foreign key to portfolio_types table
            $table->foreignId('portfolio_types_id')->constrained()->onDelete('cascade');

            // foreign key to portfolios table
            $table->string('portfolio_name');
            $table->string('annual_report')->nullable();
            $table->string('trust_deed_document')->nullable();
            $table->string('insurance_document')->nullable();
            $table->string('valuation_report')->nullable();

            // system information
            $table->string('status')->default('active');
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();

            // default information
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