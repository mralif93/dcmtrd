<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantApproval extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'checklist_id',
        'tenant_id',
        'lease_id',
        'approval_type',
        'od_approved',
        'ld_verified',
        'od_approval_date',
        'ld_verification_date',
        'notes',
        'submitted_to_ld_date',
        'ld_response_date'
    ];

    protected $casts = [
        'od_approved' => 'boolean',
        'ld_verified' => 'boolean',
        'od_approval_date' => 'date',
        'ld_verification_date' => 'date',
        'submitted_to_ld_date' => 'date',
        'ld_response_date' => 'date'
    ];

    /**
     * Get the checklist that this approval belongs to.
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
    
    /**
     * Get the tenant being approved.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    
    /**
     * Get the lease being approved.
     */
    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
    
    /**
     * Check if approval is completed.
     */
    public function isApprovalComplete()
    {
        return $this->od_approved && $this->ld_verified;
    }
    
    /**
     * Check if the LD verification is within the required response time (3 days).
     */
    public function isWithinResponseTime()
    {
        if (!$this->submitted_to_ld_date || !$this->ld_response_date) {
            return true; // No response required yet
        }
        
        // Check if LD responded within 3 days of OD submission
        return $this->ld_response_date->diffInDays($this->submitted_to_ld_date) <= 3;
    }
    
    /**
     * Check if response is overdue.
     */
    public function isResponseOverdue()
    {
        if (!$this->submitted_to_ld_date || $this->ld_response_date) {
            return false; // Either not submitted or already responded
        }
        
        return now()->diffInDays($this->submitted_to_ld_date) > 3;
    }
    
    /**
     * Update the tenant's approval status based on this approval.
     */
    public function updateTenantStatus()
    {
        if ($this->isApprovalComplete()) {
            $this->tenant->update([
                'approval_status' => 'approved',
                'approval_date' => $this->ld_verification_date,
                'last_approval_date' => $this->ld_verification_date
            ]);
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Check if this is a new tenant approval.
     */
    public function isNewApproval()
    {
        return $this->approval_type === 'new';
    }
    
    /**
     * Check if this is a tenant renewal approval.
     */
    public function isRenewalApproval()
    {
        return $this->approval_type === 'renewal';
    }

    /**
     * Calculate the response time in days from submission to LD response.
     * 
     * @return int|null
     */
    public function getResponseTimeAttribute()
    {
        if ($this->submitted_to_ld_date && $this->ld_response_date) {
            return $this->submitted_to_ld_date->diffInDays($this->ld_response_date);
        }
        return null;
    }
    
    /**
     * Get the approval status label.
     * 
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        if ($this->ld_verified) {
            return 'Verified by Legal Department';
        } elseif ($this->od_approved) {
            return 'Approved by Operations Department';
        } elseif ($this->submitted_to_ld_date) {
            return 'Submitted to Legal Department';
        } else {
            return 'Pending';
        }
    }
}