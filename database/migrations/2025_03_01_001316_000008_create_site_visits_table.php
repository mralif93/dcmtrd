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
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();

            // Foreign key to the properties table
            $table->foreignId('property_id')->constrained()->onDelete('cascade');

            // site visit information
            $table->date('date_visit');
            $table->time('time_visit');
            $table->string('trustee')->nullable();
            $table->string('manager')->nullable();
            $table->string('maintenance_manager')->nullable();
            $table->string('building_manager')->nullable();
            $table->text('notes')->nullable();
            $table->date('submission_date')->nullable();
            $table->boolean('follow_up_required')->default(false);
            $table->string('attachment')->nullable();

            // system information
            $table->string('status')->default('pending');
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->dateTime('approval_datetime')->nullable();

            // default value
            $table->timestamps();
            $table->softDeletes();
            
            // Add index for better performance
            $table->index('date_visit');
            $table->index('time_visit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_visits');
    }
};