<?php

namespace App\Models;

use App\Models\FacilityInformation;
use Illuminate\Database\Eloquent\Model;

class AdiHolder extends Model
{
    protected $guarded = [];

    public function facilityInformation()
    {
        return $this->belongsTo(FacilityInformation::class);
    }
}
