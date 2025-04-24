<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChecklistInternalAreaCondition extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'checklist_internal_area_conditions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_door_window_satisfied',
        'door_window_remarks',
        'is_staircase_satisfied',
        'staircase_remarks',
        'is_toilet_satisfied',
        'toilet_remarks',
        'is_ceiling_satisfied',
        'ceiling_remarks',
        'is_wall_satisfied',
        'wall_remarks',
        'is_water_seeping_satisfied',
        'water_seeping_remarks',
        'is_loading_bay_satisfied',
        'loading_bay_remarks',
        'is_basement_car_park_satisfied',
        'basement_car_park_remarks',
        'internal_remarks',
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
        'is_door_window_satisfied' => 'boolean',
        'is_staircase_satisfied' => 'boolean',
        'is_toilet_satisfied' => 'boolean',
        'is_ceiling_satisfied' => 'boolean',
        'is_wall_satisfied' => 'boolean',
        'is_water_seeping_satisfied' => 'boolean',
        'is_loading_bay_satisfied' => 'boolean',
        'is_basement_car_park_satisfied' => 'boolean',
        'approval_datetime' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the checklist that owns this internal area condition.
     */
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}