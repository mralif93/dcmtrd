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
        Schema::create('leases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('lease_name');
            $table->string('demised_premises')->nullable();
            $table->string('permitted_use')->nullable();
            $table->string('option_to_renew')->nullable();
            $table->string('term_years')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('base_rate_year_1', 15, 2)->unsigned();
            $table->decimal('monthly_gsto_year_1', 15, 2)->unsigned();
            $table->decimal('base_rate_year_2', 15, 2)->unsigned();
            $table->decimal('monthly_gsto_year_2', 15, 2)->unsigned();
            $table->decimal('base_rate_year_3', 15, 2)->unsigned();
            $table->decimal('monthly_gsto_year_3', 15, 2)->unsigned();
            $table->decimal('space', 15, 2)->unsigned();
            $table->string('tenancy_type')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status')->default('pending');
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes for better performance
            $table->index(['lease_name', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};