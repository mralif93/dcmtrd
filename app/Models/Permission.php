<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Permission extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'short_name',
        'full_name',
        'description',
    ];

    /**
     * Get the users that have this permission.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'permission_users');
    }

    /**
     * Get all permission assignments for this permission.
     */
    public function permissionUsers(): HasMany
    {
        return $this->hasMany(PermissionUser::class);
    }
}