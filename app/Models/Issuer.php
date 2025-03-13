<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issuer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'issuer_short_name',
        'issuer_name',
        'registration_number',
        'debenture',
        'trustee_role_1',
        'trustee_role_2',
        'trust_deed_date',
        'trust_amount_escrow_sum',
        'no_of_share',
        'outstanding_size',
        'status',
        'prepared_by',
        'verified_by',
        'approval_datetime',
        'remarks',
    ];

    protected $casts = [
        'trust_deed_date' => 'date',
        'approval_datetime' => 'datetime',
    ];

    public function bonds()
    {
        return $this->hasMany(Bond::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function facilities()
    {
        return $this->hasMany(FacilityInformation::class);
    }

    public function documents()
    {
        return $this->hasManyThrough(
            RelatedDocument::class,
            FacilityInformation::class,
            'issuer_id',    // FK on facilities table
            'facility_id',  // FK on documents table
            'id',           // Local key on issuers
            'id'            // Local key on facilities
        );
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'Rejected');
    }

    // Get the count of related bonds
    public function getBondsCountAttribute()
    {
        return $this->bonds()->count();
    }

    // Get the count of active bonds
    public function getActiveBondsCountAttribute()
    {
        return $this->bonds()->where('status', 'Active')->count();
    }
}