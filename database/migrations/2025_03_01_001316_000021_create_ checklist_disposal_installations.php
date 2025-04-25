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
        Schema::create('checklist_disposal_installations', function (Blueprint $table) {
            $table->id();

            // Foreign key to the checklist table
            $table->foreignId('checklist_id')->constrained()->onDelete('cascade');
            
            // Component information fields
            $table->string('component_name')->nullable();
            $table->date('component_date')->nullable();
            $table->text('component_scope_of_work')->nullable();
            $table->string('component_status')->nullable();
        
            // System information
            $table->string('status')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();
        
            // Default fields
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_disposal_installations');
    }
};