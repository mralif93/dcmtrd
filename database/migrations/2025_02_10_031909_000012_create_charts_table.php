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
        Schema::create('charts', function (Blueprint $table) {
            $table->id();

            // foreign key to the bonds table
            $table->foreignId('bond_id')->constrained('bonds')->onDelete('cascade');

            // chart details
            $table->date('availability_date');
            $table->dateTime('approval_date_time');
            $table->string('chart_type');
            $table->json('chart_data');
            $table->date('period_from');
            $table->date('period_to');

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
        Schema::dropIfExists('charts');
    }
};
