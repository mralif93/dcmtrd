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
        'site_visit_id',
        'visitation_date',
        'purpose',
        'report_submission_date',
        'report_attachment',
        'follow_up_required',
        'remarks',
        'status',
        'prepared_by',
        'verified_by',
        'approval_datetime',
    ];

    protected $casts = [
        'visitation_date' => 'date',
        'report_submission_date' => 'date',
        'follow_up_required' => 'boolean',
        'approval_datetime' => 'datetime',
    ];

    /**
     * Get the site visit that owns this log entry.
     */
    public function siteVisit()
    {
        return $this->belongsTo(SiteVisit::class);
    }

    /**
     * Get the property associated with this site visit log through the site visit.
     */
    public function property()
    {
        return $this->hasOneThrough(Property::class, SiteVisit::class, 'id', 'id', 'site_visit_id', 'property_id');
    }

    /**
     * Scope a query to only include logs with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include logs that require follow-up.
     */
    public function scopeRequiringFollowUp($query)
    {
        return $query->where('follow_up_required', true);
    }

    /**
     * Scope a query to only include logs from a specific date range.
     */
    public function scopeDateBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('visitation_date', [$startDate, $endDate]);
    }
    
    /**
     * Get the report attachment URL
     *
     * @return string|null
     */
    public function getReportAttachmentUrlAttribute()
    {
        return $this->report_attachment ? asset('storage/' . $this->report_attachment) : null;
    }
}