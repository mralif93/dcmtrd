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
            $table->date('trade_date');
            $table->time('input_time');
            $table->decimal('amount', 15, 2);
            $table->decimal('price', 10, 2);
            $table->decimal('yield', 5, 2);
            $table->date('value_date');
            $table->foreignId('bond_id')->constrained('bonds')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trading_activities');
    }
};