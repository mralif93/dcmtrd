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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('unit_number');
            $table->string('unit_type');
            $table->decimal('square_footage', 8, 2);
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->decimal('ceiling_height', 4, 2);
            $table->string('floor_type');
            $table->boolean('furnished')->default(false);
            $table->string('view_type');
            $table->decimal('base_rent', 10, 2);
            $table->string('exposure');
            $table->integer('floor_number');
            $table->boolean('pets_allowed')->default(false);
            $table->boolean('washer_dryer')->default(false);
            $table->boolean('parking_included')->default(false);
            $table->string('heating_type');
            $table->string('cooling_type');
            $table->json('appliances_included');
            $table->date('last_renovation')->nullable();
            $table->string('condition');
            $table->string('status');
            $table->decimal('utility_cost', 8, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
