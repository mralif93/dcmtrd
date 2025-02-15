<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BondInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'bond_id',
        'principal',
        'islamic_concept',
        'isin_code',
        'stock_code',
        'instrument_code',
        'category',
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
        'facility_code'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'maturity_date' => 'date',
        'prev_coupon_payment_date' => 'date',
        'first_coupon_payment_date' => 'date',
        'next_coupon_payment_date' => 'date',
        'last_coupon_payment_date' => 'date',
        'last_traded_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function bond(): BelongsTo
    {
        return $this->belongsTo(Bond::class);
    }

    public function ratingMovements()
    {
        return $this->hasMany(RatingMovement::class)->orderBy('effective_date', 'desc');
    }

    public function paymentSchedules(): HasMany
    {
        return $this->hasMany(PaymentSchedule::class, 'bond_info_id');
    }

    public function tradingActivities(): HasMany
    {
        return $this->hasMany(TradingActivity::class, 'bond_info_id');
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(Redemption::class, 'bond_info_id');
    }

    /**
     * Custom Accessors
     */
    public function getFormattedCouponRateAttribute(): string
    {
        return number_format($this->coupon_rate, 4) . '%';
    }

    public function getDaysToMaturityAttribute(): int
    {
        return now()->diffInDays($this->maturity_date, false);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->whereDate('maturity_date', '>', now());
    }

    public function scopeWithHighYield($query, $threshold = 5.0)
    {
        return $query->where('coupon_rate', '>', $threshold);
    }
}