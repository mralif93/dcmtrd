<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chart extends Model
{
    use HasFactory;

    protected $fillable = [
        'bond_id',
        'chart_type',
        'chart_data',
        'period_from',
        'period_to'
    ];

    protected $casts = [
        'chart_data' => 'json',
        'period_from' => 'date',
        'period_to' => 'date',
    ];

    public function bond(): BelongsTo
    {
        return $this->belongsTo(Bond::class);
    }
}