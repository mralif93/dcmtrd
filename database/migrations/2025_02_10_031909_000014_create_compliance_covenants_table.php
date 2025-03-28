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
        Schema::create('compliance_covenants', function (Blueprint $table) {
            $table->id();
            $table->string('financial_year_end');
            $table->date('letter_of_issuer')->nullable();
            $table->string('audited_financial_statements')->nullable(); // due date 1
            $table->string('compliance_certificate')->nullable(); // due date 1
            $table->string('unaudited_financial_statements')->nullable(); // due date 2
            $table->string('finance_service_cover_ratio')->nullable();
            $table->string('annual_budget')->nullable();
            $table->string('computation_of_finance_to_ebitda')->nullable();
            $table->string('ratio_information_on_use_of_proceeds')->nullable(); // remove
            $table->string('status')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->foreignId('issuer_id')->constrained('issuers')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliance_covenants');
    }
};
