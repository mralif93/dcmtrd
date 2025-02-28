<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->date('payment_date');
            $table->date('ex_date')->nullable();
            $table->decimal('coupon_rate', 5, 2)->nullable();
            $table->date('adjustment_date')->nullable();
            $table->foreignId('bond_id')->constrained('bonds')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_schedules');
    }
};