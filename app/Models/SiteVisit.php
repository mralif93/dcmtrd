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
     * @var array
     */
    protected $casts = [
        'date_visit' => 'date',
    ];

    /**
     * Get the property that owns the site visit.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
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
}