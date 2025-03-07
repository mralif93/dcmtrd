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
     * Get latest checklist by type.
     */
    public function latestChecklistByType($type)
    {
        return $this->checklists()
            ->where('type', $type)
            ->latest('approval_date')
            ->first();
    }
    
    /**
     * Get documentation checklist.
     */
    public function documentationChecklist()
    {
        return $this->latestChecklistByType('documentation');
    }
    
    /**
     * Get tenant checklist.
     */
    public function tenantChecklist()
    {
        return $this->latestChecklistByType('tenant');
    }
    
    /**
     * Get condition checklist.
     */
    public function conditionChecklist()
    {
        return $this->latestChecklistByType('condition');
    }
    
    /**
     * Get improvement checklist.
     */
    public function improvementChecklist()
    {
        return $this->latestChecklistByType('improvement');
    }
    
    /**
     * Get all documentation items through checklists.
     */
    public function getAllDocumentationItems()
    {
        return DocumentationItem::whereIn('checklist_id', $this->checklists()->pluck('id'));
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
}