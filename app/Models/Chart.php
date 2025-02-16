<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    use HasFactory;

    protected $fillable = [
        'availability_date',
        'approval_date_time',
        'chart_type',
        'chart_data',
        'period_from',
        'period_to',
        'bond_id',
    ];

    protected $casts = [
        'availability_date' => 'date',
        'approval_date_time' => 'datetime',
        'period_from' => 'date',
        'period_to' => 'date',
        'chart_data' => 'array',
    ];

    public function bond()
    {
        return $this->belongsTo(Bond::class);
    }
}