<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityDiary extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'issuer_id',
        'purpose',
        'letter_date',
        'due_date',
        'status',
        'remarks',
        'prepared_by',
        'verified_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'letter_date' => 'date',
        'due_date' => 'date',
    ];

    /**
     * Get the issuer that owns the activity diary entry.
     */
    public function issuer()
    {
        return $this->belongsTo(Issuer::class);
    }
}