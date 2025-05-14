<?php

namespace App\Models;

use App\Models\Issuer;
use App\Models\SecurityDocRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListSecurity extends Model
{
    protected $table = 'list_securities';

    protected $guarded = [];

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Issuer::class);
    }

    public function hasRequest()
    {
        return $this->requests()->exists();
    }

    public function hasPendingRequest()
    {
        return $this->hasMany(SecurityDocRequest::class)
            ->where('status', 'pending')
            ->exists();
    }

    public function hasWithdrawnRequest()
    {
        return $this->hasMany(SecurityDocRequest::class)
            ->where('status', 'withdrawal')
            ->exists();
    }

    public function hasExistingRequest()
    {
        return $this->hasMany(SecurityDocRequest::class)
            ->exists();
    }

    public function latestDocRequest(): HasOne
    {
        return $this->hasOne(SecurityDocRequest::class, 'list_security_id')->latestOfMany();
    }

    // ListSecurity.php
    public function securityDocRequests()
    {
        return $this->hasMany(SecurityDocRequest::class);
    }
}
