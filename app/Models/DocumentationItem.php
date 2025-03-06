<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentationItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'checklist_id',
        'item_number',
        'document_type',
        'description',
        'validity_date',
        'location',
        'is_prefilled'
    ];

    protected $casts = [
        'validity_date' => 'date',
        'is_prefilled' => 'boolean',
    ];

    /**
     * Get the checklist that owns this documentation item.
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
    
    /**
     * Get the property through the checklist relationship.
     */
    public function property()
    {
        return $this->hasOneThrough(Property::class, Checklist::class, 'id', 'id', 'checklist_id', 'property_id');
    }
    
    /**
     * Check if the document is expired.
     */
    public function isExpired()
    {
        if (!$this->validity_date) {
            return false;
        }
        
        return $this->validity_date->isPast();
    }
    
    /**
     * Check if the document is expiring soon (within 90 days).
     */
    public function isExpiringSoon()
    {
        if (!$this->validity_date) {
            return false;
        }
        
        return $this->validity_date->diffInDays(now()) <= 90 && !$this->isExpired();
    }
    
    /**
     * Check if this item is not applicable.
     */
    public function isNotApplicable()
    {
        return strtoupper($this->location) === 'N/A' || $this->description === 'N/A';
    }
}