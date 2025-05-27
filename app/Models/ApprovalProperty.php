<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalProperty extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'approval_properties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_id',
        'date_of_approval',
        'description',
        'estimated_amount',
        'remarks',
        'attachment',
        'status',
        'prepared_by',
        'verified_by',
        'approval_datetime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_of_approval' => 'date',
        'estimated_amount' => 'decimal:2',
        'approval_datetime' => 'datetime',
    ];

    /**
     * Get the property that owns the approval.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the user who prepared the approval.
     */
    public function preparedBy()
    {
        return $this->belongsTo(User::class, 'prepared_by', 'id');
    }

    /**
     * Get the user who verified the approval.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by', 'id');
    }

    /**
     * Scope a query to only include approvals with a specific status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Format the estimated amount as currency.
     *
     * @return string
     */
    public function getFormattedAmountAttribute()
    {
        return number_format($this->estimated_amount, 2);
    }

    /**
     * Determine if the approval has an attachment.
     *
     * @return bool
     */
    public function hasAttachment()
    {
        return !empty($this->attachment);
    }

    /**
     * Get the attachment URL.
     *
     * @return string|null
     */
    public function getAttachmentUrlAttribute()
    {
        return $this->attachment ? asset('storage/' . $this->attachment) : null;
    }
}
