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
        Schema::create('placement_fund_transfers', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('details')->nullable();
            $table->decimal('placement_amount', 15, 2)->nullable();
            $table->decimal('fund_transfer_amount', 15, 2)->nullable();
            $table->foreignId('prepared_by_id')->nullable()->constrained('users');
            $table->foreignId('reviewed_by_id')->nullable()->constrained('users');
            $table->foreignId('verified_by_id')->nullable()->constrained('users');
            $table->string('status')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('placement_fund_transfers');
    }
};
