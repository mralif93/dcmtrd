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
            $table->string('principle_type')->nullable();
            $table->string('islamic_concept')->nullable();
            $table->date('maturity_date')->nullable();
            $table->string('instrument')->nullable();
            $table->string('instrument_type')->nullable();
            $table->boolean('guaranteed')->nullable();
            $table->decimal('total_guaranteed', 15, 2)->nullable();
            $table->string('indicator')->nullable();
            $table->string('facility_rating')->nullable();
            $table->decimal('facility_amount', 15, 2)->nullable();
            $table->decimal('available_limit', 15, 2)->nullable();
            $table->decimal('outstanding_amount', 15, 2)->nullable();
            $table->string('trustee_security_agent')->nullable();
            $table->string('lead_arranger')->nullable();
            $table->string('facility_agent')->nullable();
            $table->date('availability_date')->nullable();
            $table->string('status')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->foreignId('issuer_id')->constrained('issuers')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
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
