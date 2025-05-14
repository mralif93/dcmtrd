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
        Schema::create('adi_holders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_information_id')->constrained('facility_informations')->onDelete('cascade');
            $table->string('adi_holder');
            $table->string('stock_code');
            $table->decimal('nominal_value', 20, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adi_holders');
    }
};
