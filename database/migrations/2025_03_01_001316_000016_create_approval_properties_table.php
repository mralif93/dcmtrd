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
        Schema::create('approval_properties', function (Blueprint $table) {
            $table->id();

            // foreign key to properties table
            $table->foreignId('property_id')->constrained()->onDelete('cascade');

            // approval details
            $table->date('date_of_approval');
            $table->text('description');
            $table->decimal('estimated_amount', 15, 2)->unsigned()->nullable();
            $table->string('attachment')->nullable();

            // system information
            $table->string('status')->default('pending');
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();

            // default information
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes for better performance
            $table->index(['property_id', 'date_of_approval']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_properties');
    }
};