<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionUser extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
}
