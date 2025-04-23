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
        Schema::create('checklist_tenant', function (Blueprint $table) {
            $table->id();

            // foreign key to the checklist table
            $table->foreignId('checklist_id')->constrained()->onDelete('cascade');

            // foreign key to the tenant table
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');

            // tenant fields
            $table->text('notes')->nullable();

            // system information
            $table->string('status')->default('pending');
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();

            // default fields
            $table->timestamps();
            $table->softDeletes();

            // Add indexes for better performance
            $table->index(['checklist_id', 'tenant_id']);
            $table->index(['status', 'prepared_by', 'verified_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_tenant');
    }
};