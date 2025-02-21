<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issuer extends Model
{
    use HasFactory;

    protected $fillable = [
        'issuer_short_name',
        'issuer_name',
        'registration_number',
        'debenture',
        'trustee_fee_amount_1',
        'trustee_fee_amount_2',
        'trustee_role_1',
        'trustee_role_2',
        'reminder_1',
        'reminder_2',
        'reminder_3',
        'trust_deed_date',
    ];

    protected $casts = [
        'reminder_1' => 'date',
        'reminder_2' => 'date',
        'reminder_3' => 'date',
        'trust_deed_date' => 'date',
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
}