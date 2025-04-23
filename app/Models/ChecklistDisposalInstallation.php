<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Checklist;
use App\Models\ChecklistDisposalInstallationItem;

class ChecklistDisposalInstallation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'checklist_id',
        'component_name',
        'component_date',
        'component_scope_of_work',
        'component_status',
        'status',
        'prepared_by',
        'verified_by',
        'remarks',
        'approval_datetime',
    ];

    protected $casts = [
        'component_date' => 'date',
        'approval_datetime' => 'datetime',
    ];

    /**
     * Get the parent checklist.
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}
