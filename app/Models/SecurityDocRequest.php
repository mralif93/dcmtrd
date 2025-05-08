<?php

namespace App\Models;

use App\Models\ListSecurity;
use Illuminate\Database\Eloquent\Model;

class SecurityDocRequest extends Model
{
    protected $guarded = [];

    public function listSecurity()
    {
        return $this->belongsTo(ListSecurity::class);
    }
}
