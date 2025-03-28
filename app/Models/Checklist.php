<?php

// app/Models/Checklist.php
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
        
        // Legal Documentation section (1.0)
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
        
        // Tenancy Agreement section (2.0)
        'tenant_name',
        'tenant_property',
        'tenancy_approval_date',
        'tenancy_commencement_date',
        'tenancy_expiry_date',
        
        // External Area Conditions (3.0)
        'is_general_cleanliness_satisfied',
        'is_fencing_gate_satisfied',
        'is_external_facade_satisfied',
        'is_car_park_satisfied',
        'is_land_settlement_satisfied',
        'is_rooftop_satisfied',
        'is_drainage_satisfied',
        'external_remarks',
        
        // Internal Area Conditions (4.0)
        'is_door_window_satisfied',
        'is_staircase_satisfied',
        'is_toilet_satisfied',
        'is_ceiling_satisfied',
        'is_wall_satisfied',
        'is_water_seeping_satisfied',
        'is_loading_bay_satisfied',
        'is_basement_car_park_satisfied',
        'internal_remarks',
        
        // Property Development section (5.0)
        'development_expansion_status',
        'renovation_status',
        'external_repainting_status',
        
        // Disposal/Installation/Replacement section (5.4)
        'water_tank_status',
        'air_conditioning_approval_date',
        'air_conditioning_scope',
        'air_conditioning_status',
        'lift_escalator_status',
        'fire_system_status',
        'other_property',
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
        'air_conditioning_approval_date' => 'date',
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
}