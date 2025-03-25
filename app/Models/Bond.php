<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bond extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bond_sukuk_name',
        'sub_name',
        'rating',
        'category',
        'principal',
        'islamic_concept',
        'isin_code',
        'stock_code',
        'instrument_code',
        'sub_category',
        'issue_date',
        'maturity_date',
        'coupon_rate',
        'coupon_type',
        'coupon_frequency',
        'day_count',
        'issue_tenure_years',
        'residual_tenure_years',
        'last_traded_yield',
        'last_traded_price',
        'last_traded_amount',
        'last_traded_date',
        'coupon_accrual',
        'prev_coupon_payment_date',
        'first_coupon_payment_date',
        'next_coupon_payment_date',
        'last_coupon_payment_date',
        'amount_issued',
        'amount_outstanding',
        'lead_arranger',
        'facility_agent',
        'facility_code',
        'status',
        'prepared_by',
        'verified_by',
        'remarks',
        'approval_datetime',
        'issuer_id',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'maturity_date' => 'date',
        'last_traded_date' => 'date',
        'coupon_accrual' => 'date',
        'prev_coupon_payment_date' => 'date',
        'first_coupon_payment_date' => 'date',
        'next_coupon_payment_date' => 'date',
        'last_coupon_payment_date' => 'date',
        'approval_datetime' => 'datetime',
        'coupon_rate' => 'decimal:4',
        'issue_tenure_years' => 'decimal:4',
        'residual_tenure_years' => 'decimal:4',
        'last_traded_yield' => 'decimal:2',
        'last_traded_price' => 'decimal:2',
        'last_traded_amount' => 'decimal:2',
        'amount_issued' => 'decimal:2',
        'amount_outstanding' => 'decimal:2',
    ];

    public function issuer()
    {
        return $this->belongsTo(Issuer::class);
    }

    // Add your relationships here (based on what I can see in your controller)
    public function ratingMovements()
    {
        return $this->hasMany(RatingMovement::class);
    }

    public function paymentSchedules()
    {
        return $this->hasMany(PaymentSchedule::class);
    }

    public function tradingActivities()
    {
        return $this->hasMany(TradingActivity::class);
    }

    public function redemption()
    {
        return $this->hasOne(Redemption::class);
    }

    public function charts()
    {
        return $this->hasMany(Chart::class);
    }
}