<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SiteVisitLog extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'property_id',
        'visit_day',
        'visit_month',
        'visit_year',
        'purpose',
        'remarks',
        'category',
        'status',
        'prepared_by',
        'verified_by',
        'approval_datetime',
    ];

    protected $casts = [
        'approval_datetime' => 'datetime',
    ];

    /**
     * Get the property that owns this log entry.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Scope a query to only include logs with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include logs from a specific year.
     */
    public function scopeInYear($query, $year)
    {
        return $query->where('visit_year', $year);
    }

    /**
     * Scope a query to only include logs from a specific month.
     */
    public function scopeInMonth($query, $month)
    {
        return $query->where('visit_month', $month);
    }
    
    /**
     * Get the full visit date by combining day, month, and year
     *
     * @return string
     */
    public function getFullVisitDateAttribute()
    {
        if ($this->visit_day && $this->visit_month && $this->visit_year) {
            return "{$this->visit_day}/{$this->visit_month}/{$this->visit_year}";
        }
        
        return null;
    }
}