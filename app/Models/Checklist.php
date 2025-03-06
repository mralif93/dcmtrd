<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use HasFactory, SoftDeletes;

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
        'confirmed_date'
    ];

    protected $casts = [
        'approval_date' => 'date',
        'prepared_date' => 'date',
        'confirmed_date' => 'date',
    ];

    /**
     * Get the property that this checklist belongs to.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the documentation items for this checklist.
     */
    public function documentationItems()
    {
        return $this->hasMany(DocumentationItem::class);
    }

    /**
     * Get the tenant approvals for this checklist.
     */
    public function tenantApprovals()
    {
        return $this->hasMany(TenantApproval::class);
    }

    /**
     * Get the condition checks for this checklist.
     */
    public function conditionChecks()
    {
        return $this->hasMany(ConditionCheck::class);
    }

    /**
     * Get the property improvements for this checklist.
     */
    public function propertyImprovements()
    {
        return $this->hasMany(PropertyImprovement::class);
    }
    
    /**
     * Get the site visits associated with this checklist.
     */
    public function siteVisits()
    {
        return $this->hasMany(SiteVisit::class);
    }
    
    /**
     * Get external area condition checks.
     */
    public function externalConditionChecks()
    {
        return $this->conditionChecks()->where('section', 'External Area');
    }
    
    /**
     * Get internal area condition checks.
     */
    public function internalConditionChecks()
    {
        return $this->conditionChecks()->where('section', 'Internal Area');
    }
    
    /**
     * Check if the checklist has been prepared.
     */
    public function isPrepared()
    {
        return !is_null($this->prepared_by) && !is_null($this->prepared_date);
    }
    
    /**
     * Check if the checklist has been confirmed.
     */
    public function isConfirmed()
    {
        return !is_null($this->confirmed_by) && !is_null($this->confirmed_date);
    }
    
    /**
     * Check if the checklist is a documentation checklist.
     */
    public function isDocumentationChecklist()
    {
        return $this->type === 'documentation';
    }
    
    /**
     * Check if the checklist is a tenant checklist.
     */
    public function isTenantChecklist()
    {
        return $this->type === 'tenant';
    }
    
    /**
     * Check if the checklist is a condition checklist.
     */
    public function isConditionChecklist()
    {
        return $this->type === 'condition';
    }
    
    /**
     * Check if the checklist is an improvement checklist.
     */
    public function isImprovementChecklist()
    {
        return $this->type === 'improvement';
    }
}