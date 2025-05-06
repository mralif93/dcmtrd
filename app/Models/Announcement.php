<?php

namespace App\Models;

use App\Models\FacilityInformation;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $casts = [
        'announcement_date' => 'date',
    ];

    public function facility()
    {
        return $this->belongsTo(FacilityInformation::class, 'facility_id');
    }
}