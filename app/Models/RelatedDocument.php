<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class RelatedDocument extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

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