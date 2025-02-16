<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingMovement extends Model
{
    use HasFactory;

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