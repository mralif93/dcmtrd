<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RatingMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'bond_info_id',
        'rating_agency',
        'effective_date',
        'rating_tenure',
        'rating',
        'rating_action',
        'rating_outlook',
        'rating_watch'
    ];

    protected $casts = [
        'effective_date' => 'date',
    ];

    public function bondInfo(): BelongsTo
    {
        return $this->belongsTo(BondInfo::class);
    }
}