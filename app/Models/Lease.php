<?php

namespace App\Models;

use App\Models\Tenant;
use App\Models\TenancyLetter;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lease extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'leases';

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
        'option_to_renew',
        'term_years',
        'start_date',
        'end_date',
        'base_rate_year_1',
        'monthly_gsto_year_1',
        'remarks_year_1',
        'base_rate_year_2',
        'monthly_gsto_year_2',
        'remarks_year_2',
        'base_rate_year_3',
        'monthly_gsto_year_3',
        'remarks_year_3',
        'space',
        'tenancy_type',
        'attachment',
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
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'approval_datetime' => 'datetime',
    ];

    /**
     * Get the tenant that owns the lease.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the lease's attachment URL.
     *
     * @return string
     */
    public function getAttachmentUrlAttribute()
    {
        return $this->attachment ? asset('storage/' . $this->attachment) : null;
    }

    /**
     * Get the tenancy letters associated with the lease.
     */
    public function tenancyLetters()
    {
        return $this->hasMany(TenancyLetter::class);
    }

    /**
     * Get the first tenancy letter associated with the lease.
     */
    public function tenancyLetter()
    {
        return $this->hasOne(TenancyLetter::class);
    }

    // check is tenancy letter under lease id already created or not
    public function hasTenancyLetter()
    {
        return $this->tenancyLetters()->exists();
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

        // Calculate yearly proportions
        $totalMonths = $months;
        $year1Months = min(12, $totalMonths);
        $year2Months = ($totalMonths > 12) ? min(12, $totalMonths - 12) : 0;
        $year3Months = ($totalMonths > 24) ? min(12, $totalMonths - 24) : 0;

        // Calculate total value for each year period
        $year1Value = ($this->base_rate_year_1 + $this->monthly_gsto_year_1) * $year1Months;
        $year2Value = ($this->base_rate_year_2 + $this->monthly_gsto_year_2) * $year2Months;
        $year3Value = ($this->base_rate_year_3 + $this->monthly_gsto_year_3) * $year3Months;

        return $year1Value + $year2Value + $year3Value;
    }

    /**
     * Check if the lease is expiring within a specified number of days.
     *
     * @param int $days
     * @return bool
     */
    public function isExpiringWithin($days)
    {
        $futureDate = now()->addDays($days);
        return $this->end_date->lte($futureDate) && $this->end_date->gte(now());
    }

    /**
     * Scope a query to only include leases expiring within a specified number of days.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpiringWithin($query, $days)
    {
        $futureDate = now()->addDays($days);
        return $query->where('end_date', '<=', $futureDate)
            ->where('end_date', '>=', now())
            ->where('status', 'active');
    }
}
