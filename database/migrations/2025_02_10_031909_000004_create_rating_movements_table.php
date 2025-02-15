<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rating_movements', function (Blueprint $table) {
            $table->id();

            // Foreign key
            $table->foreignId('bond_info_id')->constrained('bond_infos')->onDelete('cascade');
            
            // Rating Details
            $table->string('rating_agency', 100);
            $table->date('effective_date');
            $table->integer('rating_tenure'); // In months
            $table->string('rating', 10);
            
            // Rating Actions
            $table->string('rating_action', 50);
            $table->string('rating_outlook', 50);
            $table->string('rating_watch', 50);
            
            // Timestamps
            $table->timestamps();
            
            // Composite index for common query patterns
            $table->index(['bond_info_id', 'effective_date', 'rating_agency']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('rating_movements');
    }
};