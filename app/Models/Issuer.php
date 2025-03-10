<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issuer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

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