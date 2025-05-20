<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportBatchItems extends Model
{
    protected $table = 'report_batch_items';

    protected $guarded = [];

    protected $casts = [
        'trust_deed_date' => 'date',
        'issue_date' => 'date',
        'maturity_date' => 'date',
    ];
    
}
