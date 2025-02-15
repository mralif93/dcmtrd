<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'bond_info_id',
        'start_date',
        'end_date',
        'payment_date',
        'ex_date',
        'coupon_rate',
        'adjustment_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'payment_date' => 'date',
        'ex_date' => 'date',
        'adjustment_date' => 'date',
    ];

    public function bondInfo(): BelongsTo
    {
        return $this->belongsTo(BondInfo::class);
    }
}