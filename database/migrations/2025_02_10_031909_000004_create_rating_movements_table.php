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
            $table->string('rating_agency');
            $table->date('effective_date');
            $table->string('rating_tenure');
            $table->string('rating');
            $table->string('rating_action');
            $table->string('rating_outlook');
            $table->string('rating_watch');
            $table->foreignId('bond_id')->constrained('bonds')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rating_movements');
    }
};