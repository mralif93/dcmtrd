<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_id',
        'name',
        'contact_person',
        'email',
        'phone',
        'commencement_date',
        'expiry_date',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'commencement_date' => 'date',
        'expiry_date' => 'date'
    ];

    /**
     * Get the property that the tenant belongs to.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the leases for the tenant.
     */
    public function leases()
    {
        return $this->hasMany(Lease::class);
    }

    /**
     * Scope a query to only include active tenants.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if tenant's lease is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expiry_date->isPast();
    }

    /**
     * Get the remaining days until expiry.
     *
     * @return int
     */
    public function daysUntilExpiry()
    {
        if ($this->isExpired()) {
            return 0;
        }
        
        return now()->diffInDays($this->expiry_date);
    }
}
