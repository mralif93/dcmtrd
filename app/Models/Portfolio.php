<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'foundation_date' => 'date',
        'fiscal_year_end' => 'date',
        'active_status' => 'boolean',
        'total_assets' => 'decimal:2',
        'market_cap' => 'decimal:2',
        'available_funds' => 'decimal:2',
        'target_return' => 'decimal:2'
    ];

    /**
     * Get the full URL for the annual report.
     */
    public function getAnnualReportUrlAttribute()
    {
        return $this->annual_report ? asset('storage/' . $this->annual_report) : null;
    }

    /**
     * Get the full URL for the trust deed document.
     */
    public function getTrustDeedDocumentUrlAttribute()
    {
        return $this->trust_deed_document ? asset('storage/' . $this->trust_deed_document) : null;
    }

    /**
     * Get the full URL for the insurance document.
     */
    public function getInsuranceDocumentUrlAttribute()
    {
        return $this->insurance_document ? asset('storage/' . $this->insurance_document) : null;
    }

    /**
     * Get the full URL for the valuation report.
     */
    public function getValuationReportUrlAttribute()
    {
        return $this->valuation_report ? asset('storage/' . $this->valuation_report) : null;
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function financialReports()
    {
        return $this->hasMany(FinancialReport::class);
    }
}
