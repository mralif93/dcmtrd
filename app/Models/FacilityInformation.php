<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class FacilityInformation extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'facility_informations';

    protected $fillable = [
        'issuer_short_name',
        'facility_code',
        'facility_number',
        'facility_name',
        'principle_type',
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
        'availability_date',
        'status',
        'prepared_by',
        'verified_by',
        'approval_datetime',
        'remarks',
        'issuer_id',
    ];

    protected $casts = [
        'maturity_date' => 'date',
        'availability_date' => 'date',
        'guaranteed' => 'boolean',
    ];

    // Relationships
    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Issuer::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(RelatedDocument::class, 'facility_id');
    }

    // Scopes
    public function scopeWithDocuments(Builder $query): void
    {
        $query->whereHas('documents');
    }

    public function scopeActive(Builder $query): void
    {
        $query->whereDate('maturity_date', '>=', now());
    }

    // Accessors
    public function getHasDocumentsAttribute(): bool
    {
        return $this->documents()->exists();
    }

    public function getDocumentsCountAttribute(): int
    {
        return $this->documents()->count();
    }
}