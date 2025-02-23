<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'request_date' => 'date',
        'scheduled_date' => 'date',
        'completion_date' => 'date',
        'estimated_time' => 'datetime',
        'actual_time' => 'datetime',
        'materials_used' => 'json',
        'images' => 'json',
        'recurring' => 'boolean',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
