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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('ssn')->unique();
            $table->date('date_of_birth');
            $table->string('current_address');
            $table->string('employment_status');
            $table->string('employer_name')->nullable();
            $table->decimal('annual_income', 12, 2);
            $table->string('emergency_contact');
            $table->string('credit_score');
            $table->date('background_check_date');
            $table->string('background_check_status');
            $table->string('identity_proof_type');
            $table->boolean('pets')->default(false);
            $table->integer('number_of_occupants');
            $table->json('vehicle_info')->nullable();
            $table->string('insurance_policy')->nullable();
            $table->string('preferred_contact_method');
            $table->json('bank_details');
            $table->boolean('active_status')->default(true);
            $table->json('lease_history')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
