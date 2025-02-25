<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RatingMovement extends Model
{
    use HasFactor, SoftDeletes;

    protected $fillable = [
        'rating_agency',
        'effective_date',
        'rating_tenure',
        'rating',
        'rating_action',
        'rating_outlook',
        'rating_watch',
        'bond_id',
    ];

    protected $casts = [
        'effective_date' => 'date',
    ];

    public function bond()
    {
        return $this->belongsTo(Bond::class);
    }
}