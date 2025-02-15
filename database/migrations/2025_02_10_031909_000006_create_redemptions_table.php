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

            //  Foreign Key
            $table->foreignId('bond_info_id')->constrained('bond_infos')->onDelete('cascade');

            $table->boolean('allow_partial_call')->default(false);
            $table->date('last_call_date');
            $table->boolean('redeem_nearest_denomination')->default(false);

            // Timestamps
            $table->timestamps();
        
            // Indexes
            $table->index('bond_info_id');
            $table->index('last_call_date');
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
