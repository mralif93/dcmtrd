<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appointments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'portfolio_id',
        'date_of_approval',
        'party_name',
        'description',
        'estimated_amount',
        'remarks',
        'attachment',
        'status',
        'prepared_by',
        'verified_by',
        'approval_datetime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_of_approval' => 'date',
        'estimated_amount' => 'decimal:2',
        'approval_datetime' => 'datetime',
    ];

    /**
     * Get the portfolio that owns the appointment.
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
    
    /**
     * Scope a query to only include appointments with a specific status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
