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
}