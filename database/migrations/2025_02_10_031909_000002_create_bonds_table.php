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
        Schema::create('bonds', function (Blueprint $table) {
            $table->id();

            // Foreign Key
            $table->foreignId('issuer_id')->constrained()->onDelete('cascade');

            $table->string('bond_sukuk_name', 100);
            $table->string('sub_name', 100);
            $table->string('rating', 10);
            $table->string('category', 50);
            $table->date('last_traded_date');
            $table->decimal('last_traded_yield', 8, 2);
            $table->decimal('last_traded_price', 15, 2);
            $table->decimal('last_traded_amount', 15, 2);
            $table->decimal('o_s_amount', 15, 2);
            $table->integer('residual_tenure');
            $table->string('facility_code', 50);
            $table->string('status', 20);
            $table->dateTime('approval_date_time');

            // Indexes
            $table->index('issuer_id');
            $table->index('last_traded_date');
            $table->index('rating');

            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bonds');
    }
};