<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'payment_date',
        'ex_date',
        'coupon_rate',
        'adjustment_date',
        'bond_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'payment_date' => 'date',
        'ex_date' => 'date',
        'adjustment_date' => 'date',
    ];

    public function bond()
    {
        return $this->belongsTo(Bond::class);
    }
}