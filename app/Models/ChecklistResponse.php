<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistResponse extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'completed_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'response_data' => 'json',
        'images' => 'json',
        'attachments' => 'json'
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
