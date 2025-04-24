<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistExternalAreaCondition extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'checklist_external_area_conditions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_general_cleanliness_satisfied',
        'general_cleanliness_remarks',
        'is_fencing_gate_satisfied',
        'fencing_gate_remarks',
        'is_external_facade_satisfied',
        'external_facade_remarks',
        'is_car_park_satisfied',
        'car_park_remarks',
        'is_land_settlement_satisfied',
        'land_settlement_remarks',
        'is_rooftop_satisfied',
        'rooftop_remarks',
        'is_drainage_satisfied',
        'drainage_remarks',
        'external_remarks',
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
        'is_general_cleanliness_satisfied' => 'boolean',
        'is_fencing_gate_satisfied' => 'boolean',
        'is_external_facade_satisfied' => 'boolean',
        'is_car_park_satisfied' => 'boolean',
        'is_land_settlement_satisfied' => 'boolean',
        'is_rooftop_satisfied' => 'boolean',
        'is_drainage_satisfied' => 'boolean',
        'approval_datetime' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the checklist that owns this external area condition.
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}