<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'permission',
        'job_title',
        'department',
        'office_location',
        'email_verified_at',
        'password',
        'two_factor_code',
        'two_factor_expires_at',
        'two_factor_verified',
        'two_factor_enabled',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'two_factor_enabled' => 'boolean',
        'two_factor_verified' => 'boolean',
        'two_factor_expires_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    /**
     * Reset the two-factor authentication code and expiration.
     *
     * @return void
     */
    public function resetTwoFactorCode(): void
    {
        $this->forceFill([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
            'two_factor_verified' => false,
        ])->save();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function getTwoFactorEnabledAttribute(): bool
    {
        return $this->attributes['two_factor_enabled'] ?? false;
    }
    
    public function getTwoFactorExpiresAtAttribute(): ?\DateTime
    {
        return $this->attributes['two_factor_expires_at']
            ? \Carbon\Carbon::parse($this->attributes['two_factor_expires_at'])
            : null;
    }

    /**
     * Get all permissions for the user.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_users');
    }

    /**
     * Check if user has a specific permission.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->permissions()->where('short_name', $permission)->exists();
    }

    /**
     * Get permissions as an array of permission names.
     *
     * @return array
     */
    public function getPermissionsArray()
    {
        return $this->permissions->pluck('short_name')->map(function($name) {
            return strtolower($name);
        })->toArray();
    }
}