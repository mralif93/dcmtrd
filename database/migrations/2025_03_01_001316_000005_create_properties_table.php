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
            $table->string('category');
            $table->string('batch_no');
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('postal_code');
            $table->decimal('land_size', 10, 2)->unsigned();
            $table->decimal('gross_floor_area', 10, 2)->unsigned();
            $table->string('usage');
            $table->decimal('value', 15, 2)->unsigned();
            $table->string('ownership');
            $table->decimal('share_amount', 15, 2)->unsigned();
            $table->decimal('market_value', 15, 2)->unsigned();
            $table->string('status')->default('Draft')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes for better performance
            $table->index(['name', 'address', 'city']);
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
