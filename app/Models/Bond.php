<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bond extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'bond_sukuk_name',
        'sub_name',
        'rating',
        'category',
        'principal',
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
        'approval_date_time',
        'issuer_id',
        'prepared_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'maturity_date' => 'date',
        'coupon_rate'=> 'decimal:2',
        'issue_tenure_years' => 'decimal:4',
        'residual_tenure_years' => 'decimal:4',
        'last_traded_yield' => 'decimal:2',
        'last_traded_price' => 'decimal:2',
        'last_traded_amount' => 'decimal:2',
        'last_traded_date' => 'date:Y-m-d',
        'coupon_accrual' => 'date:Y-m-d',
        'prev_coupon_payment_date' => 'date:Y-m-d',
        'first_coupon_payment_date' => 'date:Y-m-d',
        'next_coupon_payment_date' => 'date:Y-m-d',
        'last_coupon_payment_date' => 'date:Y-m-d',
        'amount_issued' => 'decimal:2',
        'amount_outstanding' => 'decimal:2',
        'approval_date_time' => 'datetime:Y-m-d H:i:s',
    ];

    // Relationships
    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Issuer::class);
    }

    public function ratingMovements(): HasMany
    {
        return $this->hasMany(RatingMovement::class)->latest();
    }

    public function paymentSchedules(): HasMany
    {
        return $this->hasMany(PaymentSchedule::class)->orderBy('payment_date');
    }

    public function redemption(): HasOne
    {
        return $this->hasOne(Redemption::class, 'bond_id');
    }

    public function tradingActivities(): HasMany
    {
        return $this->hasMany(TradingActivity::class)->latest();
    }

    public function charts(): HasMany
    {
        return $this->hasMany(Chart::class)->orderBy('period_from');
    }

    public function preparedBy()
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopeMatured($query)
    {
        return $query->where('status', 'Matured');
    }

    public function scopeByIssuer($query, $issuerId)
    {
        return $query->where('issuer_id', $issuerId);
    }

    public function scopeWithCouponType($query, $type)
    {
        return $query->where('coupon_type', $type);
    }

    // Accessors
    public function getFormattedCouponRateAttribute(): string
    {
        return $this->coupon_rate.'%';
    }

    public function getDaysToMaturityAttribute(): int
    {
        return now()->diffInDays($this->maturity_date, false);
    }

    public function getIsTradableAttribute(): bool
    {
        return $this->status === 'Active' && $this->days_to_maturity > 0;
    }

    // Mutators
    public function setBondSukukNameAttribute($value)
    {
        $this->attributes['bond_sukuk_name'] = ucwords(strtolower($value));
    }

    public function setFacilityCodeAttribute($value)
    {
        $this->attributes['facility_code'] = strtoupper($value);
    }

    // Business logic
    public function markAsMatured()
    {
        if ($this->maturity_date->isPast()) {
            $this->update(['status' => 'Matured']);
        }
    }

    public function updateOutstandingAmount()
    {
        $this->amount_outstanding = $this->amount_issued - $this->principal;
        $this->save();
    }
}