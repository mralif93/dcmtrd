<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

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
        'date_visit',
        'time_visit',
        'trustee',
        'manager',
        'maintenance_manager',
        'building_manager',
        'notes',
        'submission_date',
        'follow_up_required',
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
        'date_visit' => 'date',
        'time_visit' => 'date',
        'submission_date' => 'date',
        'follow_up_required' => 'boolean',
        'approval_datetime' => 'datetime',
    ];

    /**
     * Get the property that owns the site visit.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the checklist for this site visit.
     */
    public function checklist()
    {
        return $this->hasOne(Checklist::class);
    }

    /**
     * Get the formatted visit time.
     */
    public function getFormattedTimeAttribute()
    {
        // Check if time_visit is already a Carbon instance after casting
        if ($this->time_visit instanceof Carbon) {
            return $this->time_visit->format('h:i A');
        }
        
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
}