<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteVisit extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'property_id',
        'date_visit',
        'time_visit',
        'inspector_name',
        'notes',
        'attachment',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_visit' => 'date',
        'time_visit' => 'time',
    ];

    /**
     * Get the property that the site visit belongs to.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the status badge HTML.
     * 
     * @return string
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'scheduled' => 'bg-primary',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
            'postponed' => 'bg-warning',
        ];

        $badgeClass = $badges[$this->status] ?? 'bg-secondary';

        return '<span class="badge ' . $badgeClass . '">' . ucfirst($this->status) . '</span>';
    }

    /**
     * Scope a query to only include scheduled site visits.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope a query to only include upcoming site visits.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date_site_visit', '>=', now())
                    ->where('status', 'scheduled');
    }

    /**
     * Check if this site visit has an attachment.
     *
     * @return bool
     */
    public function hasAttachment()
    {
        return !empty($this->attachment);
    }
}