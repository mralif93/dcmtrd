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
            
            // Foreign Key
            $table->foreignId('bond_info_id')->constrained('bond_infos')->onDelete('cascade');

            // Trading Details
            $table->date('trade_date');
            $table->time('input_time');
            $table->decimal('amount', 18, 2)->comment("In RM millions"); // e.g., 1.50 = RM 1.5 million
            $table->decimal('price', 15, 4); // e.g., 102.5000
            $table->decimal('yield', 5, 2)->comment("Percentage"); // e.g., 5.25%
            $table->date('value_date');
            
            $table->timestamps();

            // Indexes
            $table->index(['bond_info_id', 'trade_date']);
            $table->index('trade_date');
            $table->index('value_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trading_activities');
    }
};