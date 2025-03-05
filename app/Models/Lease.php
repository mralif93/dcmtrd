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
     * @var array
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
     * @var array
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
     * Check if the lease is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->end_date->isPast();
    }

    /**
     * Check if the lease is expiring soon (within 3 months).
     *
     * @return bool
     */
    public function isExpiringSoon()
    {
        $nearExpiry = now()->addMonths(3);
        return $this->end_date->lte($nearExpiry) && $this->end_date->gte(now());
    }

    /**
     * Get the remaining lease term in days.
     *
     * @return int
     */
    public function getRemainingTerm()
    {
        if ($this->isExpired()) {
            return 0;
        }
        
        return now()->diffInDays($this->end_date);
    }

    /**
     * Calculate the total contract value.
     *
     * @return float
     */
    public function getTotalContractValue()
    {
        $months = $this->start_date->diffInMonths($this->end_date);
        
        switch ($this->rental_frequency) {
            case 'daily':
                return $this->rental_amount * 30 * $months;
            case 'weekly':
                return $this->rental_amount * 4 * $months;
            case 'monthly':
                return $this->rental_amount * $months;
            case 'quarterly':
                return $this->rental_amount * ($months / 3);
            case 'biannual':
                return $this->rental_amount * ($months / 6);
            case 'annual':
                return $this->rental_amount * ($months / 12);
            default:
                return $this->rental_amount * $months;
        }
    }
}