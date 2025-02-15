<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelatedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_id',
        'document_name',
        'document_type',
        'upload_date',
        'file_path'
    ];

    protected $casts = [
        'upload_date' => 'date',
    ];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(FacilityInformation::class, 'facility_id');
    }
}