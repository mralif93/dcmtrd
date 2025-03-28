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
            $table->string('demised_premises');
            $table->string('permitted_use');
            $table->decimal('rental_amount', 15, 2)->unsigned();
            $table->string('rental_frequency')->default('monthly');
            $table->boolean('option_to_renew')->default(true);
            $table->string('term_years');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('active');
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
