<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'furnished' => 'boolean',
        'pets_allowed' => 'boolean',
        'washer_dryer' => 'boolean',
        'parking_included' => 'boolean',
        'appliances_included' => 'json',
        'last_renovation' => 'date',
        'square_footage' => 'decimal:2',
        'ceiling_height' => 'decimal:2',
        'base_rent' => 'decimal:2',
        'utility_cost' => 'decimal:2'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }

    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    public function siteVisits()
    {
        return $this->hasMany(SiteVisit::class);
    }

    public function checklistResponses()
    {
        return $this->hasMany(ChecklistResponse::class);
    }

    public function currentLease()
    {
        return $this->hasOne(Lease::class)->where('status', 'active')->latest();
    }

    public function currentTenant()
    {
        return $this->hasOneThrough(
            Tenant::class,
            Lease::class,
            'unit_id',
            'id',
            'id',
            'tenant_id'
        )->where('leases.status', 'active');
    }
}
