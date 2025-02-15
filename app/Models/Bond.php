<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bond extends Model
{
    use HasFactory;

    protected $fillable = [
        'issuer_id',
        'bond_sukuk_name',
        'sub_name',
        'rating',
        'category',
        'last_traded_date',
        'last_traded_yield',
        'last_traded_price',
        'last_traded_amount',
        'o_s_amount',
        'residual_tenure',
        'facility_code',
        'status',
        'approval_date_time'
    ];

    protected $casts = [
        'last_traded_date' => 'datetime:Y-m-d',
        'approval_date_time' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Issuer::class);
    }

    public function bondInfo(): HasOne
    {
        return $this->hasOne(BondInfo::class);
    }

    public function charts(): HasMany
    {
        return $this->hasMany(Chart::class);
    }
}