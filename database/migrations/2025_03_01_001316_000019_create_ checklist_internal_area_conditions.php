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
        Schema::create('checklist_internal_area_conditions', function (Blueprint $table) {
            $table->id();

            // foreign key to the checklist table
            $table->foreignId('checklist_id')->constrained()->onDelete('cascade');
            
            // internal area conditions fields
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
        Schema::dropIfExists('checklist_internal_area_conditions');
    }
};