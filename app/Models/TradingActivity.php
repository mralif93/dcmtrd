<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TradingActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'trade_date',
        'input_time',
        'amount',
        'price',
        'yield',
        'value_date',
        'bond_id',
    ];

    protected $casts = [
        'trade_date' => 'date',
        'value_date' => 'date',
        'input_time' => 'datetime',
    ];

    public function bond()
    {
        return $this->belongsTo(Bond::class);
    }
}