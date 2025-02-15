<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'redemption_id',
        'start_date',
        'end_date',
        'call_price'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function redemption(): BelongsTo
    {
        return $this->belongsTo(Redemption::class);
    }
}