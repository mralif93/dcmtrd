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
        // Property improvements/maintenance (section 5.0 in the images)
        Schema::create('property_improvements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_id')->constrained()->onDelete('cascade');
            $table->string('item_number'); // e.g., '5.1', '5.4'
            $table->string('improvement_type'); // e.g., 'Development', 'Renovation', etc.
            $table->string('sub_type')->nullable(); // For categorized items like in 5.4
            $table->date('approval_date')->nullable();
            $table->text('scope_of_work')->nullable();
            $table->string('status')->default('pending'); // pending, completed, not_applicable
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_improvements');
    }
};
