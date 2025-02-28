<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'date_of_birth' => 'date',
        'background_check_date' => 'date',
        'pets' => 'boolean',
        'active_status' => 'boolean',
        'vehicle_info' => 'json',
        'bank_details' => 'json',
        'lease_history' => 'json',
        'annual_income' => 'decimal:2'
    ];

    protected $hidden = [
        'ssn',
        'bank_details'
    ];

    public function leases()
    {
        return $this->hasMany(Lease::class);
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

    public function currentUnit()
    {
        return $this->hasOneThrough(
            Unit::class,
            Lease::class,
            'tenant_id',
            'id',
            'id',
            'unit_id'
        )->where('leases.status', 'active');
    }
}
