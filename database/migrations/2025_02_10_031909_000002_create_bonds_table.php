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
        Schema::create('bonds', function (Blueprint $table) {
            $table->id();
            $table->string('bond_sukuk_name');
            $table->string('sub_name')->nullable();
            $table->string('rating')->nullable();
            $table->string('category')->nullable();
            $table->string('principal')->nullable();
            $table->string('isin_code')->nullable();
            $table->string('stock_code')->nullable();
            $table->string('instrument_code')->nullable();
            $table->string('sub_category')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('maturity_date')->nullable();
            $table->decimal('coupon_rate', 6, 4)->nullable();
            $table->string('coupon_type')->nullable();
            $table->string('coupon_frequency')->nullable();
            $table->string('day_count')->nullable();
            $table->decimal('issue_tenure_years', 8, 4)->nullable();
            $table->decimal('residual_tenure_years', 8, 4)->nullable();
            $table->decimal('last_traded_yield', 5, 2)->nullable();
            $table->decimal('last_traded_price', 15, 2)->nullable();
            $table->decimal('last_traded_amount', 15, 2)->nullable();
            $table->date('last_traded_date')->nullable();
            $table->date('coupon_accrual')->nullable();
            $table->date('prev_coupon_payment_date')->nullable();
            $table->date('first_coupon_payment_date')->nullable();
            $table->date('next_coupon_payment_date')->nullable();
            $table->date('last_coupon_payment_date')->nullable();
            $table->decimal('amount_issued', 15, 2)->nullable();
            $table->decimal('amount_outstanding', 15, 2)->nullable();
            $table->string('lead_arranger')->nullable();
            $table->string('facility_agent')->nullable();
            $table->string('facility_code')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('approval_date_time')->nullable();
            $table->foreignId('issuer_id')->constrained('issuers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bonds');
    }
};