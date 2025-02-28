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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('postal_code');
            $table->string('property_type');
            $table->decimal('square_footage', 10, 2);
            $table->decimal('land_area', 10, 2);
            $table->integer('year_built');
            $table->decimal('purchase_price', 15, 2);
            $table->decimal('current_value', 15, 2);
            $table->decimal('expected_roi', 8, 2);
            $table->date('acquisition_date');
            $table->string('zoning_type');
            $table->string('building_class');
            $table->integer('number_of_floors');
            $table->integer('parking_spaces');
            $table->string('primary_use');
            $table->decimal('occupancy_rate', 5, 2);
            $table->string('property_manager');
            $table->text('insurance_details');
            $table->string('tax_parcel_id');
            $table->date('last_renovation_date')->nullable();
            $table->string('status');
            $table->decimal('annual_property_tax', 12, 2);
            $table->decimal('insurance_cost', 12, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
