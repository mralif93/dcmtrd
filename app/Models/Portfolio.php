<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'portfolio_name',
        'annual_report',
        'trust_deed_document',
        'insurance_document',
        'valuation_report',
        'status',
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
}