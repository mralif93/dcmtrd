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
        Schema::create('checklist_legal_documentations', function (Blueprint $table) {
            $table->id();

            // foreign key to the checklist table
            $table->foreignId('checklist_id')->constrained()->onDelete('cascade');
            
            // legal documentation fields
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
        Schema::dropIfExists('checklist_legal_documentations');
    }
};