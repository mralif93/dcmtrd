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
        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->foreignId('bank_id')->constrained('banks')->onDelete('restrict');
            $table->foreignId('financial_type_id')->constrained('financial_types')->onDelete('restrict');
            $table->string('batch_no')->nullable();
            $table->string('purpose');
            $table->string('tenure');
            $table->string('installment_date');
            $table->string('profit_type');
            $table->decimal('profit_rate', 8, 4)->unsigned();
            $table->decimal('process_fee', 15, 2)->unsigned();
            $table->decimal('total_facility_amount', 15, 2)->unsigned();
            $table->decimal('utilization_amount', 15, 2)->unsigned();
            $table->decimal('outstanding_amount', 15, 2)->unsigned();
            $table->decimal('interest_monthly', 15, 2)->unsigned();
            $table->decimal('security_value_monthly', 15, 2)->unsigned();
            $table->string('facilities_agent');
            $table->string('agent_contact')->nullable();
            $table->string('valuer');
            $table->string('status')->default('pending');
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes for better performance
            $table->index(['installment_date', 'purpose']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financials');
    }
};