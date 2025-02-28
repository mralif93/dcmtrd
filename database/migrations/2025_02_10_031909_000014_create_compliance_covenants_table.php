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
            $table->string('issuer_short_name');
            $table->string('financial_year_end');
            $table->string('audited_financial_statements')->nullable();
            $table->string('unaudited_financial_statements')->nullable();
            $table->string('compliance_certificate')->nullable();
            $table->string('finance_service_cover_ratio')->nullable();
            $table->string('annual_budget')->nullable();
            $table->string('computation_of_finance_to_ebitda')->nullable();
            $table->string('ratio_information_on_use_of_proceeds')->nullable();
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
