<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_name',
        'document_type',
        'upload_date',
        'file_path',
        'facility_id',
    ];

    protected $casts = [
        'upload_date' => 'date',
    ];

    public function facility()
    {
        return $this->belongsTo(FacilityInformation::class, 'facility_id');
    }
}