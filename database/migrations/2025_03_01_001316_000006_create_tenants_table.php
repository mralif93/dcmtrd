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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('commencement_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->date('expiry_date');
            $table->string('status')->default('active');
            $table->string('approval_status')->nullable(); // Added for checklist integration
            $table->date('last_approval_date')->nullable(); // Added for checklist integration
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes for better performance
            $table->index(['name', 'commencement_date', 'expiry_date', 'approval_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
