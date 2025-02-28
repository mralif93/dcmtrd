<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiteVisit extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'visit_date' => 'datetime',
        'actual_visit_start' => 'datetime',
        'actual_visit_end' => 'datetime',
        'interested' => 'boolean',
        'requirements' => 'json',
        'follow_up_required' => 'boolean',
        'follow_up_date' => 'date',
        'quoted_price' => 'decimal:2'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
