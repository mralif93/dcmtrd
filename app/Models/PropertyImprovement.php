<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyImprovement extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'checklist_id',
        'item_number',
        'improvement_type',
        'sub_type',
        'approval_date',
        'scope_of_work',
        'status'
    ];

    protected $casts = [
        'approval_date' => 'date',
    ];

    /**
     * Get the checklist that owns this property improvement.
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
     * Check if the improvement is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
    
    /**
     * Check if the improvement is pending.
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }
    
    /**
     * Check if the improvement is not applicable.
     */
    public function isNotApplicable()
    {
        return $this->status === 'not_applicable';
    }
    
    /**
     * Scope a query to only include development type improvements.
     */
    public function scopeDevelopment($query)
    {
        return $query->where('improvement_type', 'Development');
    }
    
    /**
     * Scope a query to only include renovation type improvements.
     */
    public function scopeRenovation($query)
    {
        return $query->where('improvement_type', 'Renovation');
    }
    
    /**
     * Scope a query to only include equipment replacement type improvements.
     */
    public function scopeEquipmentReplacement($query)
    {
        return $query->where('improvement_type', 'Equipment Replacement');
    }
    
    /**
     * Scope a query to only include completed improvements.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    /**
     * Format the item number as shown in the checklist (e.g., "5.1").
     */
    public function getFormattedItemNumber()
    {
        if (strpos($this->item_number, '.') === false) {
            return '5.' . $this->item_number;
        }
        
        return $this->item_number;
    }
    
    /**
     * Get the full improvement name, including sub-type if available.
     */
    public function getFullImprovementName()
    {
        if ($this->sub_type) {
            return $this->improvement_type . ' - ' . $this->sub_type;
        }
        
        return $this->improvement_type;
    }
}