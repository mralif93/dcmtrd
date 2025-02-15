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
            
            // Foreign Key
            $table->foreignId('bond_info_id')
                ->constrained('bond_infos')
                ->onDelete('cascade');

            $table->date('start_date');
            $table->date('end_date');
            $table->date('payment_date');
            $table->date('ex_date')->index();
            $table->decimal('coupon_rate', 5, 2);
            $table->date('adjustment_date')->nullable()->index();

            // Timestamps
            $table->timestamps();

            $table->index(['bond_info_id', 'ex_date']);
            $table->index(['start_date', 'end_date']);
            $table->unique(['bond_info_id', 'start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_schedules');
    }
};