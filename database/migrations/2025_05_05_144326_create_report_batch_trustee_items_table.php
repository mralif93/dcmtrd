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
        Schema::create('report_batch_trustee_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_batch_id')->constrained('report_batch_trustees')->onDelete('cascade');
            $table->string('issuer_short_name')->nullable();
            $table->string('issuer_name')->nullable();
            $table->string('debenture')->nullable();
            $table->decimal('trust_amount_escrow_sum', 18, 2)->nullable();
            $table->unsignedBigInteger('no_of_share')->nullable();
            $table->decimal('outstanding_size', 18, 2)->nullable();
            $table->decimal('total_trustee_fee', 18, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_batch_trustee_items');
    }
};
