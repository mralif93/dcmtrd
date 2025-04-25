<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;    

class Checklist extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_visit_id',
        'status',
        'prepared_by',
        'verified_by',
        'remarks',
        'approval_datetime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'approval_datetime' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    /**
     * Get the site visit that owns this checklist.
     */
    public function siteVisit()
    {
        return $this->belongsTo(SiteVisit::class);
    }

    /**
     * Get the legal documentation section of this checklist.
     */
    public function legalDocumentation()
    {
        return $this->hasOne(ChecklistLegalDocumentation::class);
    }

    /**
     * Get the external area conditions section of this checklist.
     */
    public function externalAreaCondition()
    {
        return $this->hasOne(ChecklistExternalAreaCondition::class);
    }

    /**
     * Get the internal area conditions section of this checklist.
     */
    public function internalAreaCondition()
    {
        return $this->hasOne(ChecklistInternalAreaCondition::class);
    }

    /**
     * Get the property development section of this checklist.
     */
    public function propertyDevelopment()
    {
        return $this->hasOne(ChecklistPropertyDevelopment::class);
    }

    /**
     * Get the disposal/installation section of this checklist.
     */
    public function disposalInstallation()
    {
        return $this->hasMany(ChecklistDisposalInstallation::class);
    }

    /**
     * The tenants associated with this checklist.
     */
    public function tenants()
    {
        return $this->belongsToMany(Tenant::class, 'checklist_tenant')
            ->withPivot('id', 'notes', 'status', 'prepared_by', 'verified_by', 'approval_datetime')
            ->withTimestamps();
    }
}