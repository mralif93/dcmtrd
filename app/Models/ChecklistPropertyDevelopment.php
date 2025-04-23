<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistPropertyDevelopment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'checklist_property_developments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'checklist_id',
        'development_date',
        'development_scope_of_work',
        'development_status',
        'renovation_date',
        'renovation_scope_of_work',
        'renovation_status',
        'external_repainting_date',
        'external_repainting_scope_of_work',
        'external_repainting_status',
        'others_proposals_approvals_date',
        'others_proposals_approvals_scope_of_work',
        'others_proposals_approvals_status',
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
        'development_date' => 'date',
        'renovation_date' => 'date',
        'external_repainting_date' => 'date',
        'others_proposals_approvals_date' => 'date',
        'approval_datetime' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the checklist that owns this property development.
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}