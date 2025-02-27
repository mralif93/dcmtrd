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
            $table->string('rating')->nullable();
            $table->string('rating_action')->nullable();
            $table->string('rating_outlook')->nullable();
            $table->string('rating_watch')->nullable();
            $table->foreignId('bond_id')->constrained('bonds')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rating_movements');
    }
};