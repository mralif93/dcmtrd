<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Redemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'bond_info_id',
        'allow_partial_call',
        'last_call_date',
        'redeem_nearest_denomination'
    ];

    protected $casts = [
        'last_call_date' => 'date',
    ];

    public function bondInfo(): BelongsTo
    {
        return $this->belongsTo(BondInfo::class);
    }

    public function callSchedules(): HasMany
    {
        return $this->hasMany(CallSchedule::class);
    }

    public function lockoutPeriods(): HasMany
    {
        return $this->hasMany(LockoutPeriod::class);
    }
}