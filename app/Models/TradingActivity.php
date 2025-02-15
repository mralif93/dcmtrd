<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradingActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'bond_info_id',
        'trade_date',
        'input_time',
        'amount',
        'price',
        'yield',
        'value_date'
    ];

    protected $casts = [
        'trade_date' => 'date',
        'value_date' => 'date',
        'input_time' => 'datetime',
    ];

    public function bondInfo(): BelongsTo
    {
        return $this->belongsTo(BondInfo::class);
    }
}