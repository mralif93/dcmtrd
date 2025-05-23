<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistLegalDocumentation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'checklist_legal_documentations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_ref',
        'title_location',
        'trust_deed_ref',
        'trust_deed_location',
        'sale_purchase_agreement_ref',
        'sale_purchase_agreement_location',
        'lease_agreement_ref',
        'lease_agreement_location',
        'agreement_to_lease_ref',
        'agreement_to_lease_location',
        'maintenance_agreement_ref',
        'maintenance_agreement_location',
        'development_agreement_ref',
        'development_agreement_location',
        'others_ref',
        'others_location',
        'checklist_id',
        'status',
        'prepared_by',
        'verified_by',
        'remarks',
        'approval_datetime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'approval_datetime' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the checklist that owns this legal documentation.
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}
