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
        Schema::create('checklist_external_area_conditions', function (Blueprint $table) {
            $table->id();

            // foreign key to the checklist table
            $table->foreignId('checklist_id')->constrained()->onDelete('cascade');
            
            // external area conditions fields
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
            
            // system information
            $table->string('status')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            
            // default fields
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_external_area_conditions');
    }
};