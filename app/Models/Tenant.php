<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Tenant extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tenants';

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
        'approval_date',
        'expiry_date',
        'status',
        'prepared_by',
        'verified_by',
        'approval_datetime',
        'remarks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'commencement_date' => 'date',
        'approval_date' => 'date',
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
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if tenant's lease is expired.
     */
    public function isExpired()
    {
        return $this->expiry_date->isPast();
    }

    /**
     * Get the remaining days until expiry.
     */
    public function daysUntilExpiry()
    {
        if ($this->isExpired()) {
            return 0;
        }
        
        return now()->diffInDays($this->expiry_date);
    }

    /**
     * The checklists associated with this tenant.
     */
    public function checklists()
    {
        return $this->belongsToMany(Checklist::class, 'checklist_tenant')
                    ->withPivot('notes', 'status', 'prepared_by', 'verified_by', 'approval_datetime')
                    ->withTimestamps();
    }
}
