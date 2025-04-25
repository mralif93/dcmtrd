<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Announcement extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;
 
    protected $fillable = [
        'announcement_date',
        'category',
        'sub_category',
        'title',
        'description',
        'content',
        'attachment',
        'source',
        'status',
        'prepared_by',
        'verified_by',
        'approval_datetime',
        'remarks',
        'issuer_id',
    ];

    protected $casts = [
        'announcement_date' => 'date',
    ];

    public function issuer()
    {
        return $this->belongsTo(Issuer::class);
    }
}