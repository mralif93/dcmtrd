<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'issuer_id',
        'announcement_date',
        'category',
        'sub_category',
        'title',
        'description',
        'content',
        'attachment',
        'source',
    ];

    protected $casts = [
        'announcement_date' => 'date',
    ];

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Issuer::class);
    }
}