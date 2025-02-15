<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FacilityInformation extends Model
{
    use HasFactory;

    protected $table = 'facility_informations';

    protected $fillable = [
        'issuer_id',
        'facility_code',
        'facility_number',
        'facility_name',
        'principal_type',
        'islamic_concept',
        'maturity_date',
        'instrument',
        'instrument_type',
        'guaranteed',
        'total_guaranteed',
        'indicator',
        'facility_rating',
        'facility_amount',
        'available_limit',
        'outstanding_amount',
        'trustee_security_agent',
        'lead_arranger',
        'facility_agent',
        'availability_date'
    ];

    protected $casts = [
        'maturity_date' => 'date',
        'availability_date' => 'date',
        'guaranteed' => 'boolean',
    ];

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Issuer::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(RelatedDocument::class, 'facility_id');
    }
}