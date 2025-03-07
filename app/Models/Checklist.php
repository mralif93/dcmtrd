<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_id',
        'type',
        'description',
        'approval_date',
        'status',
        'assigned_department',
        'verifying_department',
        'response_time_days',
        'prepared_by',
        'prepared_date',
        'confirmed_by',
        'confirmed_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'approval_date' => 'date',
        'prepared_date' => 'date',
        'confirmed_date' => 'date',
    ];

    /**
     * Get the property that owns the checklist.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the documentation items for the checklist.
     */
    public function documentationItems()
    {
        return $this->hasMany(DocumentationItem::class);
    }

    /**
     * Get the tenant approvals for the checklist.
     */
    public function tenantApprovals()
    {
        return $this->hasMany(TenantApproval::class);
    }

    /**
     * Get the condition checks for the checklist.
     */
    public function conditionChecks()
    {
        return $this->hasMany(ConditionCheck::class);
    }

    /**
     * Get the property improvements for the checklist.
     */
    public function propertyImprovements()
    {
        return $this->hasMany(PropertyImprovement::class);
    }

    /**
     * Get the site visits for the checklist.
     */
    public function siteVisits()
    {
        return $this->hasMany(SiteVisit::class);
    }
}