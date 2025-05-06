<?php

namespace App\Models;

use App\Models\User;
use App\Models\ReportBatchItems;
use Illuminate\Database\Eloquent\Model;

class ReportBatch extends Model
{
    protected $guarded = [];

    protected $casts = [
        'cut_off_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(ReportBatchItems::class);
    }
}
