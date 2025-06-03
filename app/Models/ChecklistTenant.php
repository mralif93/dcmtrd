<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistTenant extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'checklist_tenant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'checklist_id',
        'tenant_id',
        'notes',
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
    ];

    /**
     * Get the checklist associated with this record.
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    /**
     * Get the tenant associated with this record.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }


}