<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteVisitLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'site_visit_id',
        'no',
        'visitation_date',
        'purpose',
        'status',
        'report_submission_date',
        'report_attachment',
        'follow_up_required',
        'remarks',
    ];

    protected $casts = [
        'visitation_date' => 'date',
        'report_submission_date' => 'date',
        'follow_up_required' => 'boolean',
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
     * Get the full attachment URL.
     */
    public function getReportAttachmentUrlAttribute()
    {
        if (!$this->report_attachment) {
            return null;
        }
        
        return asset('storage/' . $this->report_attachment);
    }
}