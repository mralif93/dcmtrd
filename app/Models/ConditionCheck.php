<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConditionCheck extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'checklist_id',
        'section',
        'item_number',
        'item_name',
        'is_satisfied',
        'remarks'
    ];

    protected $casts = [
        'is_satisfied' => 'boolean',
    ];

    /**
     * Get the checklist that owns this condition check.
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
     * Scope a query to only include external area checks.
     */
    public function scopeExternalArea($query)
    {
        return $query->where('section', 'External Area');
    }
    
    /**
     * Scope a query to only include internal area checks.
     */
    public function scopeInternalArea($query)
    {
        return $query->where('section', 'Internal Area');
    }
    
    /**
     * Scope a query to only include satisfied checks.
     */
    public function scopeSatisfied($query)
    {
        return $query->where('is_satisfied', true);
    }
    
    /**
     * Scope a query to only include unsatisfied checks.
     */
    public function scopeUnsatisfied($query)
    {
        return $query->where('is_satisfied', false);
    }
    
    /**
     * Check if the item is not applicable.
     */
    public function isNotApplicable()
    {
        return strtoupper($this->remarks) === 'N/A' || strtoupper($this->remarks) === 'NOT APPLICABLE';
    }
    
    /**
     * Get section number (3 for External, 4 for Internal).
     */
    public function getSectionNumber()
    {
        return $this->section === 'External Area' ? 3 : 4;
    }
    
    /**
     * Get the item identifier (e.g., "3.1" or "4.2").
     */
    public function getFormattedItemNumber()
    {
        $sectionNumber = $this->getSectionNumber();
        $itemPart = explode('.', $this->item_number);
        
        if (count($itemPart) > 1) {
            return $sectionNumber . '.' . $itemPart[1];
        }
        
        return $this->item_number;
    }
}