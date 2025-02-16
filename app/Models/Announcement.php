<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'announcement_date',
        'category',
        'sub_category',
        'title',
        'description',
        'content',
        'attachment',
        'source',
        'issuer_id',
    ];

    protected $casts = [
        'announcement_date' => 'date',
    ];

    public function issuer()
    {
        return $this->belongsTo(Issuer::class);
    }
}