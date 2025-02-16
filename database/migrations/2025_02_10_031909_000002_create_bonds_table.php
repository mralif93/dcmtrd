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
            $table->string('sub_name');
            $table->string('rating');
            $table->string('category');
            $table->decimal('o_s_amount', 15, 2);
            $table->decimal('principal', 15, 2);
            $table->string('isin_code');
            $table->string('stock_code');
            $table->string('instrument_code');
            $table->string('sub_category');
            $table->date('issue_date');
            $table->date('maturity_date');
            $table->decimal('coupon_rate', 5, 2);
            $table->string('coupon_type');
            $table->string('coupon_frequency');
            $table->string('day_count');
            $table->integer('issue_tenure_years');
            $table->integer('residual_tenure_years');
            $table->decimal('last_traded_yield', 5, 2);
            $table->decimal('last_traded_price', 10, 2);
            $table->decimal('last_traded_amount', 15, 2);
            $table->date('last_traded_date');
            $table->json('ratings');
            $table->decimal('coupon_accrual', 15, 2);
            $table->date('prev_coupon_payment_date');
            $table->date('first_coupon_payment_date');
            $table->date('next_coupon_payment_date');
            $table->date('last_coupon_payment_date');
            $table->decimal('amount_issued', 15, 2);
            $table->decimal('amount_outstanding', 15, 2);
            $table->string('lead_arranger');
            $table->string('facility_agent');
            $table->string('facility_code');
            $table->string('status');
            $table->dateTime('approval_date_time');
            $table->foreignId('issuer_id')->constrained('issuers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bonds');
    }
};