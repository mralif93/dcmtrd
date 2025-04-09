<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            
            // General property info
            $table->string('property_title')->nullable();
            $table->string('property_location')->nullable();
            
            // Legal Documentation section (1.0)
            $table->string('title_ref')->nullable();
            $table->string('title_location')->nullable();
            $table->string('trust_deed_ref')->nullable();
            $table->string('trust_deed_location')->nullable();
            $table->string('sale_purchase_agreement')->nullable();
            $table->string('lease_agreement_ref')->nullable();
            $table->string('lease_agreement_location')->nullable();
            $table->string('agreement_to_lease')->nullable();
            $table->string('maintenance_agreement_ref')->nullable();
            $table->string('maintenance_agreement_location')->nullable();
            $table->string('development_agreement')->nullable();
            $table->text('other_legal_docs')->nullable();
            
            // Tenancy Agreement section (2.0)
            $table->string('tenant_name')->nullable();
            $table->string('tenant_property')->nullable();
            $table->date('tenancy_approval_date')->nullable();
            $table->date('tenancy_commencement_date')->nullable();
            $table->date('tenancy_expiry_date')->nullable();
            
            // External Area Conditions (3.0)
            $table->boolean('is_general_cleanliness_satisfied')->nullable();
            $table->text('general_cleanliness_remarks')->nullable();
            $table->boolean('is_fencing_gate_satisfied')->nullable();
            $table->text('fencing_gate_remarks')->nullable();
            $table->boolean('is_external_facade_satisfied')->nullable();
            $table->text('external_facade_remarks')->nullable();
            $table->boolean('is_car_park_satisfied')->nullable();
            $table->text('car_park_remarks')->nullable();
            $table->boolean('is_land_settlement_satisfied')->nullable();
            $table->text('land_settlement_remarks')->nullable();
            $table->boolean('is_rooftop_satisfied')->nullable();
            $table->text('rooftop_remarks')->nullable();
            $table->boolean('is_drainage_satisfied')->nullable();
            $table->text('drainage_remarks')->nullable();
            $table->text('external_remarks')->nullable();
            
            // Internal Area Conditions (4.0)
            $table->boolean('is_door_window_satisfied')->nullable();
            $table->text('door_window_remarks')->nullable();
            $table->boolean('is_staircase_satisfied')->nullable();
            $table->text('staircase_remarks')->nullable();
            $table->boolean('is_toilet_satisfied')->nullable();
            $table->text('toilet_remarks')->nullable();
            $table->boolean('is_ceiling_satisfied')->nullable();
            $table->text('ceiling_remarks')->nullable();
            $table->boolean('is_wall_satisfied')->nullable();
            $table->text('wall_remarks')->nullable();
            $table->boolean('is_water_seeping_satisfied')->nullable();
            $table->text('water_seeping_remarks')->nullable();
            $table->boolean('is_loading_bay_satisfied')->nullable();
            $table->text('loading_bay_remarks')->nullable();
            $table->boolean('is_basement_car_park_satisfied')->nullable();
            $table->text('basement_car_park_remarks')->nullable();
            $table->text('internal_remarks')->nullable();
            
            // Property Development section (5.0)
            $table->date('development_date')->nullable();
            $table->string('development_expansion_status')->nullable();
            $table->string('development_status')->nullable();
            $table->date('renovation_date')->nullable();
            $table->string('renovation_status')->nullable();
            $table->string('renovation_completion_status')->nullable();
            $table->date('repainting_date')->nullable();
            $table->string('external_repainting_status')->nullable();
            $table->string('repainting_completion_status')->nullable();
            
            // Disposal/Installation/Replacement section (5.4)
            $table->date('water_tank_date')->nullable();
            $table->string('water_tank_status')->nullable();
            $table->string('water_tank_completion_status')->nullable();
            $table->date('air_conditioning_approval_date')->nullable();
            $table->text('air_conditioning_scope')->nullable();
            $table->string('air_conditioning_status')->nullable();
            $table->string('air_conditioning_completion_status')->nullable();
            $table->date('lift_date')->nullable();
            $table->text('lift_escalator_scope')->nullable();
            $table->string('lift_escalator_status')->nullable();
            $table->string('lift_escalator_completion_status')->nullable();
            $table->date('fire_system_date')->nullable();
            $table->text('fire_system_scope')->nullable();
            $table->string('fire_system_status')->nullable();
            $table->string('fire_system_completion_status')->nullable();
            $table->date('other_system_date')->nullable();
            $table->text('other_property')->nullable();
            $table->string('other_completion_status')->nullable();
            $table->text('other_proposals_approvals')->nullable();

            // Foreign Key
            $table->foreignId('site_visit_id')->nullable()->constrained()->onDelete('cascade');
            
            // System information
            $table->string('status')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklists');
    }
};