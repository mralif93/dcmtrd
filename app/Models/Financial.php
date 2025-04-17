<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Financial extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'portfolio_id',
        'bank_id',
        'financial_type_id',
        'batch_no',
        'purpose',
        'tenure',
        'installment_date',
        'profit_type',
        'profit_rate',
        'process_fee',
        'total_facility_amount',
        'utilization_amount',
        'outstanding_amount',
        'interest_monthly',
        'security_value_monthly',
        'facilities_agent',
        'agent_contact',
        'valuer',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'profit_rate' => 'decimal:4',
        'process_fee' => 'decimal:2',
        'total_facility_amount' => 'decimal:2',
        'utilization_amount' => 'decimal:2',
        'outstanding_amount' => 'decimal:2',
        'interest_monthly' => 'decimal:2',
        'security_value_monthly' => 'decimal:2',
    ];

    /**
     * Get the portfolio that owns the financial.
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    /**
     * Get the bank that owns the financial.
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * Get the financial type that owns the financial.
     */
    public function financialType()
    {
        return $this->belongsTo(FinancialType::class);
    }

    /**
     * The properties that belong to the financial.
     */
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'financial_property')
                    ->withPivot('property_value', 'financed_amount', 'security_value', 'valuation_date', 'remarks', 'status', 'prepared_by', 'verified_by', 'approval_datetime')
                    ->withTimestamps();
    }
}