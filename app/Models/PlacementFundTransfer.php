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
}
