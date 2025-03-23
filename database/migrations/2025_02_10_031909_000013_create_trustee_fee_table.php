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
            $table->string('month')->nullable();
            $table->integer('date')->nullable();
            $table->string('description')->nullable();
            $table->decimal('trustee_fee_amount_1', 15, 2)->nullable();
            $table->decimal('trustee_fee_amount_2', 15, 2)->nullable();
            $table->date('start_anniversary_date')->nullable();
            $table->date('end_anniversary_date')->nullable();
            $table->date('memo_to_fad')->nullable();
            $table->string('invoice_no')->unique();
            $table->date('date_letter_to_issuer')->nullable();
            $table->date('first_reminder')->nullable();
            $table->date('second_reminder')->nullable();
            $table->date('third_reminder')->nullable();
            $table->date('payment_received')->nullable();
            $table->string('tt_cheque_no')->nullable();
            $table->date('memo_receipt_to_fad')->nullable();
            $table->date('receipt_to_issuer')->nullable();
            $table->string('receipt_no')->nullable();
            $table->string('status')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->foreignId('facility_information_id')->constrained('facility_informations')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
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
