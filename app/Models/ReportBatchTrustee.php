<?php

namespace App\Models;

use App\Models\User;
use App\Models\ReportBatchTrusteeItem;
use Illuminate\Database\Eloquent\Model;

class ReportBatchTrustee extends Model
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
        return $this->hasMany(ReportBatchTrusteeItem::class, 'report_batch_id');
    }
}
