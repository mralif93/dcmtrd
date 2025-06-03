<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Portfolio extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'portfolios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'portfolio_types_id',
        'portfolio_name',
        'annual_report',
        'trust_deed_document',
        'insurance_document',
        'valuation_report',
        'status',
        'prepared_by',
        'verified_by',
        'approval_datetime',
        'remarks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'approval_datetime' => 'datetime',
    ];

    /**
     * Get the portfolio type that owns the portfolio.
     */
    public function portfolioType()
    {
        return $this->belongsTo(PortfolioType::class, 'portfolio_types_id');
    }

    /**
     * Get the properties for the portfolio.
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Get the financials for the portfolio.
     */
    public function financials()
    {
        return $this->hasMany(Financial::class);
    }

    /**
     * Get the appointments for the portfolio.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the approval forms for the portfolio.
     */
    public function approvalForms()
    {
        return $this->hasMany(ApprovalForm::class);
    }



    /**
     * Scope a query to only include portfolios with a specific status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get the total value of properties in this portfolio.
     */
    public function getTotalPropertyValue()
    {
        return $this->properties()->sum('value');
    }

    /**
     * Get the total market value of properties in this portfolio.
     */
    public function getTotalMarketValue()
    {
        return $this->properties()->sum('market_value');
    }

    /**
     * Get the number of properties in this portfolio.
     */
    public function getPropertyCount()
    {
        return $this->properties()->count();
    }

    /**
     * Check if the portfolio has any pending approval forms.
     */
    public function hasPendingApprovalForms()
    {
        return $this->approvalForms()->where('status', 'pending')->exists();
    }

    /**
     * Get the total financial facility amount for this portfolio.
     */
    public function getTotalFinancialFacilityAmount()
    {
        return $this->financials()->sum('total_facility_amount');
    }

    /**
     * Get the total utilized financial amount for this portfolio.
     */
    public function getTotalUtilizedAmount()
    {
        return $this->financials()->sum('utilization_amount');
    }

    /**
     * Check if the portfolio is fully verified.
     */
    public function isFullyVerified()
    {
        return !is_null($this->verified_by) && !is_null($this->approval_datetime);
    }

    /**
     * Get a formatted status label.
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'active' => 'Active',
            'pending' => 'Pending Verification',
            'completed' => 'Fully Processed',
            'archived' => 'Archived',
            default => ucfirst($this->status)
        };
    }
}
