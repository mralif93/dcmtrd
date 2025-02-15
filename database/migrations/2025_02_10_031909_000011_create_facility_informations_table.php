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
        Schema::create('facility_informations', function (Blueprint $table) {
            $table->id();

            // Foreign Key
            $table->foreignId('issuer_id')->constrained('issuers')->onDelete('cascade');
            
            // Facility Identification
            $table->string('facility_code', 50)->unique();
            $table->string('facility_number', 50)->unique();
            $table->string('facility_name', 100);
            
            // Facility Details
            $table->string('principal_type', 50); // Fixed typo: principle → principal
            $table->string('islamic_concept', 100)->nullable();
            $table->date('maturity_date');
            $table->string('instrument', 50);
            $table->enum('instrument_type', ['Sukuk', 'Conventional', 'Hybrid']);
            
            // Guarantee Information
            $table->boolean('guaranteed')->default(false);
            $table->decimal('total_guaranteed', 18, 2)->default(0);
            
            // Financial Indicators
            $table->string('indicator', 50);
            $table->string('facility_rating', 10);
            $table->decimal('facility_amount', 18, 2);
            $table->decimal('available_limit', 18, 2);
            $table->decimal('outstanding_amount', 18, 2);
            
            // Agent Information
            $table->string('trustee_security_agent', 100);
            $table->string('lead_arranger', 100);
            $table->string('facility_agent', 100);
            
            // Date Information
            $table->date('availability_date');

            // Timestamps
            $table->timestamps();
            
            // Indexes
            $table->index('maturity_date');
            $table->index('facility_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_informations');
    }
};
