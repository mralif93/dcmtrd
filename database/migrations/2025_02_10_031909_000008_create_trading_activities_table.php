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
        Schema::create('trading_activities', function (Blueprint $table) {
            $table->id();

            // foreign key to the bonds table
            $table->foreignId('bond_id')->constrained('bonds')->onDelete('cascade');

            // foreign key to the trading_activities table
            $table->date('trade_date');
            $table->time('input_time')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('yield', 5, 2)->nullable();
            $table->date('value_date')->nullable();
            
            // default information
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trading_activities');
    }
};