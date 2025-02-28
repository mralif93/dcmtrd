<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'acquisition_date' => 'date',
        'last_renovation_date' => 'date',
        'square_footage' => 'decimal:2',
        'land_area' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'current_value' => 'decimal:2',
        'expected_roi' => 'decimal:2',
        'occupancy_rate' => 'decimal:2',
        'annual_property_tax' => 'decimal:2',
        'insurance_cost' => 'decimal:2'
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    public function siteVisits()
    {
        return $this->hasMany(SiteVisit::class);
    }
}
