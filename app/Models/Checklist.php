<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'sections' => 'json',
        'is_template' => 'boolean',
        'active' => 'boolean'
    ];

    public function items()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    public function responses()
    {
        return $this->hasMany(ChecklistResponse::class);
    }
}
