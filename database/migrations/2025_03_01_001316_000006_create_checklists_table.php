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
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('type'); // Could be 'documentation', 'tenant', 'condition', 'improvement'
            $table->text('description')->nullable();
            $table->date('approval_date')->nullable();
            $table->string('status')->default('pending'); // pending, completed, not_applicable
            $table->string('assigned_department'); // LD, OD, etc.
            $table->string('verifying_department')->nullable(); // Department responsible for verification
            $table->integer('response_time_days')->nullable(); // Expected response time in days
            
            // Signature fields
            $table->string('prepared_by')->nullable(); // Person who prepared the checklist
            $table->date('prepared_date')->nullable(); // Date when checklist was prepared
            $table->string('confirmed_by')->nullable(); // Person who confirmed the checklist
            $table->date('confirmed_date')->nullable(); // Date when checklist was confirmed
            
            $table->timestamps();
            $table->softDeletes();
            
            // Add index for better performance
            $table->index('approval_date');
            $table->index('type');
            $table->index('assigned_department');
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
