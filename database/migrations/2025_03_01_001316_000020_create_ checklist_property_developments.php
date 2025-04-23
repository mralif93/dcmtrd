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
        Schema::create('checklist_property_developments', function (Blueprint $table) {
            $table->id();

            // foreign key to the checklist table
            $table->foreignId('checklist_id')->constrained()->onDelete('cascade');
            
            // property development fields
            $table->date('development_date')->nullable();
            $table->text('development_scope_of_work')->nullable();
            $table->string('development_status')->nullable();

            $table->date('renovation_date')->nullable();
            $table->text('renovation_scope_of_work')->nullable();
            $table->string('renovation_status')->nullable();

            $table->date('external_repainting_date')->nullable();
            $table->text('external_repainting_scope_of_work')->nullable();
            $table->string('external_repainting_status')->nullable();
            
            $table->date('others_proposals_approvals_date')->nullable();
            $table->text('others_proposals_approvals_scope_of_work')->nullable();
            $table->string('others_proposals_approvals_status')->nullable();

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
        Schema::dropIfExists('checklist_property_developments');
    }
};