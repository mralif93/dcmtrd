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
        Schema::create('financial_property', function (Blueprint $table) {
            $table->id();

            // foreign key financial
            $table->foreignId('financial_id')->constrained()->onDelete('cascade');
            // foreign key property
            $table->foreignId('property_id')->constrained()->onDelete('cascade');

            // financial property information
            $table->decimal('property_value', 15, 2)->unsigned()->nullable();
            $table->decimal('financed_amount', 15, 2)->unsigned()->nullable();
            $table->decimal('security_value', 15, 2)->unsigned()->nullable();
            $table->date('valuation_date')->nullable();
            $table->text('remarks')->nullable();

            // system information
            $table->string('status')->default('pending');
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->dateTime('approval_datetime')->nullable();

            // default value
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes for better performance
            $table->index(['financial_id', 'property_id']);
            $table->index(['property_value', 'financed_amount', 'security_value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_property');
    }
};