<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PermissionUser extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
}
