<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialProperty extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'financial_property';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'financial_id',
        'property_id',
        'property_value',
        'financed_amount',
        'security_value',
        'valuation_date',
        'remarks',
        'status',
        'prepared_by',
        'verified_by',
        'approval_datetime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'property_value' => 'decimal:2',
        'financed_amount' => 'decimal:2',
        'security_value' => 'decimal:2',
        'valuation_date' => 'date',
        'approval_datetime' => 'datetime',
    ];

    /**
     * Get the financial that owns the financial_property.
     */
    public function financial()
    {
        return $this->belongsTo(Financial::class);
    }

    /**
     * Get the property that owns the financial_property.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the user who prepared the record.
     */
    public function preparedBy()
    {
        return $this->belongsTo(User::class, 'prepared_by', 'id');
    }

    /**
     * Get the user who verified the record.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by', 'id');
    }

    /**
     * Calculate loan-to-value ratio.
     *
     * @return float|null
     */
    public function getLoanToValueRatio()
    {
        if ($this->property_value && $this->property_value > 0) {
            return ($this->financed_amount / $this->property_value) * 100;
        }
        
        return null;
    }

    /**
     * Check if the valuation is recent (less than 1 year old).
     *
     * @return bool
     */
    public function hasRecentValuation()
    {
        if (!$this->valuation_date) {
            return false;
        }
        
        return $this->valuation_date->diffInMonths(now()) < 12;
    }

    /**
     * Scope a query to only include records with a specific status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}