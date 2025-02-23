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
        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->date('report_date');
            $table->string('report_type');
            $table->decimal('total_revenue', 15, 2);
            $table->decimal('rental_revenue', 15, 2);
            $table->decimal('other_revenue', 15, 2);
            $table->decimal('operating_expenses', 15, 2);
            $table->decimal('maintenance_expenses', 15, 2);
            $table->decimal('administrative_expenses', 15, 2);
            $table->decimal('utility_expenses', 15, 2);
            $table->decimal('insurance_expenses', 15, 2);
            $table->decimal('property_tax', 15, 2);
            $table->decimal('net_operating_income', 15, 2);
            $table->decimal('net_income', 15, 2);
            $table->decimal('cash_flow', 15, 2);
            $table->decimal('debt_service', 15, 2);
            $table->decimal('capex', 15, 2);
            $table->decimal('occupancy_rate', 5, 2);
            $table->decimal('debt_ratio', 5, 2);
            $table->decimal('roi', 5, 2);
            $table->decimal('cap_rate', 5, 2);
            $table->string('currency');
            $table->string('fiscal_period');
            $table->string('prepared_by');
            $table->string('approved_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_reports');
    }
};
