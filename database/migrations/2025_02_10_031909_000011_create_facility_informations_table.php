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
            $table->string('facility_code')->unique();
            $table->string('facility_number');
            $table->string('facility_name');
            $table->string('principle_type');
            $table->string('islamic_concept');
            $table->date('maturity_date');
            $table->string('instrument');
            $table->string('instrument_type');
            $table->boolean('guaranteed');
            $table->decimal('total_guaranteed', 15, 2);
            $table->string('indicator');
            $table->string('facility_rating');
            $table->decimal('facility_amount', 15, 2);
            $table->decimal('available_limit', 15, 2);
            $table->decimal('outstanding_amount', 15, 2);
            $table->string('trustee_security_agent');
            $table->string('lead_arranger');
            $table->string('facility_agent');
            $table->date('availability_date');
            $table->foreignId('issuer_id')->constrained('issuers')->onDelete('cascade');
            $table->timestamps();
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
