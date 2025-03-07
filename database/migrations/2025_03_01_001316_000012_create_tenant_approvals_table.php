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
        Schema::create('tenant_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_id')->constrained()->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('lease_id')->nullable()->constrained()->onDelete('set null');
            
            // Approval workflow
            $table->string('approval_type')->default('new'); // 'new' or 'renewal'
            $table->boolean('od_approved')->default(false);
            $table->boolean('ld_verified')->default(false);
            $table->date('od_approval_date')->nullable();
            $table->date('ld_verification_date')->nullable();
            $table->text('notes')->nullable();
            
            // Response time tracking
            $table->date('submitted_to_ld_date')->nullable();
            $table->date('ld_response_date')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['tenant_id', 'checklist_id']);
            $table->index('approval_type');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_approvals');
    }
};
