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
        Schema::create('redemptions', function (Blueprint $table) {
            $table->id();

            // forign key to the bonds table
            $table->foreignId('bond_id')->constrained('bonds')->onDelete('cascade');

            // redemptions details
            $table->date('last_call_date');
            $table->boolean('allow_partial_call')->nullable()->default(0);
            $table->boolean('redeem_nearest_denomination')->nullable()->default(0);
            
            // default information
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redemptions');
    }
};
