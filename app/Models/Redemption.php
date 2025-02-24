<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Redemption extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'allow_partial_call',
        'last_call_date',
        'redeem_nearest_denomination',
        'bond_id',
    ];

    protected $casts = [
        'last_call_date' => 'date',
    ];

    public function bond()
    {
        return $this->belongsTo(Bond::class);
    }

    public function callSchedules()
    {
        return $this->hasMany(CallSchedule::class);
    }

    public function lockoutPeriods()
    {
        return $this->hasMany(LockoutPeriod::class);
    }
}