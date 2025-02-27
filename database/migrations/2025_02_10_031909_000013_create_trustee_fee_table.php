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
        Schema::create('trustee_fees', function (Blueprint $table) {
            $table->id();
            $table->string('month')->nullable(); // Jan, Feb, etc.
            $table->integer('date')->nullable(); // Day of the month
            $table->string('issuer'); // Company code
            $table->text('description'); // Description of the fee
            $table->decimal('fees_rm', 10, 2); // Amount in RM
            $table->date('start_anniversary_date'); // Period of anniversary
            $table->date('end_anniversary_date'); // Period of anniversary
            $table->date('memo_to_fad')->nullable(); // Date memo sent to FAD
            $table->string('invoice_no')->unique(); // Invoice number
            $table->date('date_letter_to_issuer')->nullable(); // Date letter sent to issuer
            $table->date('first_reminder')->nullable(); // First reminder date
            $table->date('second_reminder')->nullable(); // Second reminder date
            $table->date('third_reminder')->nullable(); // Third reminder date
            $table->date('payment_received')->nullable(); // Date payment received
            $table->string('tt_cheque_no')->nullable(); // TT/Cheque number
            $table->date('memo_receipt_to_fad')->nullable(); // Date memo receipt sent to FAD
            $table->date('receipt_to_issuer')->nullable(); // Date receipt sent to issuer
            $table->string('receipt_no')->nullable(); // Receipt number
            $table->timestamps(); // Laravel's created_at and updated_at
            $table->softDeletes(); // Laravel's deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trustee_fees');
    }
};
