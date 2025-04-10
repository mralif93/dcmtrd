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
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->decimal('land_size', 10, 2)->unsigned()->nullable();
            $table->decimal('gross_floor_area', 10, 2)->unsigned()->nullable();
            $table->string('usage')->nullable();
            $table->decimal('value', 15, 2)->unsigned()->nullable();
            $table->string('ownership')->nullable();
            $table->decimal('share_amount', 15, 2)->unsigned()->nullable();
            $table->decimal('market_value', 15, 2)->unsigned()->nullable();
            $table->string('status')->default('pending');
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