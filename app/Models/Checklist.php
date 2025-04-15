<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // General property info
        'property_title',
        'property_location',
        
        // 1.0 Legal Documentation
        'title_ref',
        'title_location',
        'trust_deed_ref',
        'trust_deed_location',
        'sale_purchase_agreement',
        'lease_agreement_ref',
        'lease_agreement_location',
        'agreement_to_lease',
        'maintenance_agreement_ref',
        'maintenance_agreement_location',
        'development_agreement',
        'other_legal_docs',
        
        // 2.0 Tenancy Agreement
        'tenant_name',
        'tenant_property',
        'tenancy_approval_date',
        'tenancy_commencement_date',
        'tenancy_expiry_date',
        
        // 3.0 External Area Conditions
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
        
        // 4.0 Internal Area Conditions
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
        
        // 5.0 Property Development
        'development_date',
        'development_expansion_status',
        'development_status',
        'renovation_date',
        'renovation_status',
        'renovation_completion_status',
        'repainting_date',
        'external_repainting_status',
        'repainting_completion_status',
        
        // 5.4 Disposal/Installation/Replacement
        'water_tank_date',
        'water_tank_status',
        'water_tank_completion_status',
        'air_conditioning_approval_date',
        'air_conditioning_scope',
        'air_conditioning_status',
        'air_conditioning_completion_status',
        'lift_date',
        'lift_escalator_scope',
        'lift_escalator_status',
        'lift_escalator_completion_status',
        'fire_system_date',
        'fire_system_scope',
        'fire_system_status',
        'fire_system_completion_status',
        'other_system_date',
        'other_property',
        'other_completion_status',
        'other_proposals_approvals',

        // Foreign Key
        'site_visit_id',

        // System information
        'status',
        'prepared_by',
        'verified_by',
        'remarks',
        'approval_datetime',
    ];

    protected $casts = [
        // Dates
        'tenancy_approval_date' => 'date',
        'tenancy_commencement_date' => 'date',
        'tenancy_expiry_date' => 'date',
        'development_date' => 'date',
        'renovation_date' => 'date',
        'repainting_date' => 'date',
        'water_tank_date' => 'date',
        'air_conditioning_approval_date' => 'date',
        'lift_date' => 'date',
        'fire_system_date' => 'date',
        'other_system_date' => 'date',
        'approval_datetime' => 'datetime',
        'deleted_at' => 'datetime',
        
        // Booleans
        'is_general_cleanliness_satisfied' => 'boolean',
        'is_fencing_gate_satisfied' => 'boolean',
        'is_external_facade_satisfied' => 'boolean',
        'is_car_park_satisfied' => 'boolean',
        'is_land_settlement_satisfied' => 'boolean',
        'is_rooftop_satisfied' => 'boolean',
        'is_drainage_satisfied' => 'boolean',
        'is_door_window_satisfied' => 'boolean',
        'is_staircase_satisfied' => 'boolean',
        'is_toilet_satisfied' => 'boolean',
        'is_ceiling_satisfied' => 'boolean',
        'is_wall_satisfied' => 'boolean',
        'is_water_seeping_satisfied' => 'boolean',
        'is_loading_bay_satisfied' => 'boolean',
        'is_basement_car_park_satisfied' => 'boolean',
    ];

    /**
     * Get the site visit that owns this checklist.
     */
    public function siteVisit()
    {
        return $this->belongsTo(SiteVisit::class);
    }

    /**
     * The tenants associated with this checklist.
     */
    public function tenants()
    {
        return $this->belongsToMany(Tenant::class, 'checklist_tenant')
                    ->withPivot('notes', 'status', 'prepared_by', 'verified_by', 'approval_datetime')
                    ->withTimestamps();
    }
}