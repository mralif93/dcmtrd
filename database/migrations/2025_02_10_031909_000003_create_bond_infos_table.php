<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bond_infos', function (Blueprint $table) {
            $table->id();

            // Foreign Key
            $table->foreignId('bond_id')->constrained()->onDelete('cascade');

            // General Information
            $table->decimal('principal', 18, 2);
            $table->string('islamic_concept', 100);
            $table->char('isin_code', 12)->unique();
            $table->string('stock_code', 10);
            $table->string('instrument_code', 20);
            $table->string('category', 50);
            $table->string('sub_category', 50);
            $table->date('issue_date');
            $table->date('maturity_date');

            // Coupon Information
            $table->decimal('coupon_rate', 5, 2);
            $table->string('coupon_type', 20);
            $table->string('coupon_frequency', 20);
            $table->string('day_count', 20);

            // Tenure Information
            $table->unsignedSmallInteger('issue_tenure_years');
            $table->unsignedSmallInteger('residual_tenure_years');

            // Latest Trading Information
            $table->decimal('last_traded_yield', 8, 2);
            $table->decimal('last_traded_price', 12, 4);
            $table->decimal('last_traded_amount', 18, 2);
            $table->date('last_traded_date');

            // Coupon Payment Details
            $table->decimal('coupon_accrual', 18, 2);
            $table->date('prev_coupon_payment_date');
            $table->date('first_coupon_payment_date');
            $table->date('next_coupon_payment_date');
            $table->date('last_coupon_payment_date');

            // Issuance Details
            $table->decimal('amount_issued', 18, 2);
            $table->decimal('amount_outstanding', 18, 2);

            // Additional Information
            $table->string('lead_arranger', 100);
            $table->string('facility_agent', 100);
            $table->string('facility_code', 50);

            // Timestamps
            $table->timestamps();

            // Add indexes after field definitions
            $table->index('bond_id'); // Foreign key (often used in joins)
            $table->index('isin_code'); // Unique identifier (frequent lookups)
            $table->index('issue_date'); // Common filter for bond age
            $table->index('maturity_date'); // Key for maturity-based queries
            $table->index('coupon_rate'); // Filter by interest rate
            $table->index('last_traded_date'); // Recent trading activity
            $table->index(['category', 'sub_category']); // Composite index for categorization

            // For columns used in sorting/filtering together:
            $table->index(['issue_date', 'maturity_date']);
            $table->index(['coupon_type', 'coupon_frequency']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bond_infos');
    }
};