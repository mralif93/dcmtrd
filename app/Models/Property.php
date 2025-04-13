<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'portfolio_id',
        'category',
        'batch_no',
        'name',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'land_size',
        'gross_floor_area',
        'usage',
        'value',
        'ownership',
        'share_amount',
        'market_value',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'land_size' => 'decimal:2',
        'gross_floor_area' => 'decimal:2',
        'value' => 'decimal:2',
        'share_amount' => 'decimal:2',
        'market_value' => 'decimal:2',
    ];

    /**
     * Get the portfolio that owns the property.
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    /**
     * Get the tenants for the property.
     */
    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    /**
     * Get the checklists for the property.
     */
    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

    /**
     * Get the site visits for the property.
     */
    public function siteVisits()
    {
        return $this->hasMany(SiteVisit::class);
    }

    /**
     * Get active tenants for this property.
     */
    public function activeTenantsWithLeases()
    {
        return $this->tenants()
            ->where('status', 'active')
            ->with(['leases' => function($query) {
                $query->where('start_date', '<=', now())
                      ->where('end_date', '>=', now())
                      ->where('status', 'active');
            }]);
    }
    
    /**
     * Get upcoming site visits.
     */
    public function upcomingSiteVisits()
    {
        return $this->siteVisits()
            ->where('date_visit', '>=', now())
            ->where('status', 'scheduled')
            ->orderBy('date_visit', 'asc');
    }
    
    /**
     * Get the full address of the property.
     */
    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->country}, {$this->postal_code}";
    }
    
    /**
     * Check if property has active tenants.
     */
    public function hasActiveTenants()
    {
        return $this->tenants()->where('status', 'active')->exists();
    }

    /**
     * The financials that belong to the property.
     */
    public function financials()
    {
        return $this->belongsToMany(Financial::class, 'financial_property')
                    ->withPivot('property_value', 'financed_amount', 'security_value', 'valuation_date', 'remarks', 'status', 'prepared_by', 'verified_by', 'approval_datetime')
                    ->withTimestamps();
    }
}