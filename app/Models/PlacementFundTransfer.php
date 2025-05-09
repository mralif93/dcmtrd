<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PlacementFundTransfer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'transfer_date' => 'date',
        'amount' => 'decimal:2',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'prepared_by_id');
    }
    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by_id');
    }
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by_id');
    }
}
