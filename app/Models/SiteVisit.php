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
     * @var array
     */
    protected $fillable = [
        'property_id',
        'checklist_id',
        'date_visit',
        'time_visit',
        'inspector_name',
        'notes',
        'attachment',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_visit' => 'date',
        'time_visit' => 'datetime',
    ];

    /**
     * Get the property that owns the site visit.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the checklist associated with this site visit.
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
    
    /**
     * Get the site visit's status badge class.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'completed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-yellow-100 text-yellow-800',
        };
    }
    
    /**
     * Get the formatted visit time.
     */
    public function getFormattedTimeAttribute()
    {
        return date('h:i A', strtotime($this->time_visit));
    }
    
    /**
     * Get the attachment URL.
     */
    public function getAttachmentUrlAttribute()
    {
        if (!$this->attachment) {
            return null;
        }
        
        return asset('storage/' . $this->attachment);
    }

    /**
     * Check if the site visit is scheduled.
     */
    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }
    
    /**
     * Check if the site visit is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
    
    /**
     * Check if the site visit is cancelled.
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
    
    /**
     * Check if the site visit is in the past.
     */
    public function isPast()
    {
        return $this->date_visit->isPast();
    }
    
    /**
     * Check if the site visit is in the future.
     */
    public function isFuture()
    {
        return $this->date_visit->isFuture();
    }
    
    /**
     * Check if the site visit is today.
     */
    public function isToday()
    {
        return $this->date_visit->isToday();
    }
    
    /**
     * Scope a query to only include scheduled site visits.
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }
    
    /**
     * Scope a query to only include completed site visits.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    /**
     * Scope a query to only include upcoming site visits.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date_visit', '>=', now()->toDateString())
                    ->where('status', 'scheduled')
                    ->orderBy('date_visit', 'asc');
    }
    
    /**
     * Get formatted visit date and time.
     */
    public function getFormattedVisitDateTimeAttribute()
    {
        return $this->date_visit->format('d/m/Y') . ' at ' . 
               date('h:i A', strtotime($this->time_visit));
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