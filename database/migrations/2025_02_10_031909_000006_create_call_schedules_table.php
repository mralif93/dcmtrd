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
        Schema::create('call_schedules', function (Blueprint $table) {
            $table->id();

            // foreign key to the redemptions table
            $table->foreignId('redemption_id')->constrained('redemptions')->onDelete('cascade');

            // call schedule details
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('call_price', 10, 2);

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
        Schema::dropIfExists('call_schedules');
    }
};
