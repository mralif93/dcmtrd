<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class RatingMovement extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

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