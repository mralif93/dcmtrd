<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lease extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'lease_name',
        'demised_premises',
        'permitted_use',
        'rental_amount',
        'rental_frequency',
        'option_to_renew',
        'term_years',
        'start_date',
        'end_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rental_amount' => 'decimal:2',
        'option_to_renew' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the tenant that owns the lease.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    
    /**
     * Get the property associated with the lease through tenant.
     */
    public function property()
    {
        return $this->hasOneThrough(Property::class, Tenant::class, 'id', 'id', 'tenant_id', 'property_id');
    }
}