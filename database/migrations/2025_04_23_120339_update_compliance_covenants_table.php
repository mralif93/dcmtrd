<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('compliance_covenants', function (Blueprint $table) {
            // Rename column to match form
            $table->renameColumn('letter_of_issuer', 'letter_to_issuer');

            // Drop unused column
            $table->dropColumn('ratio_information_on_use_of_proceeds');

            // Convert from string to date if needed (Laravel 11+ uses doctrine/dbal for this)
            $table->date('audited_financial_statements')->nullable()->change();
            $table->date('compliance_certificate')->nullable()->change();
            $table->date('unaudited_financial_statements')->nullable()->change();
            $table->date('finance_service_cover_ratio')->nullable()->change();
            $table->date('annual_budget')->nullable()->change();
            $table->date('computation_of_finance_to_ebitda')->nullable()->change();

            // Add due date fields
            $table->date('audited_financial_statements_due')->nullable();
            $table->date('unaudited_financial_statements_due')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('compliance_covenants', function (Blueprint $table) {
            $table->renameColumn('letter_to_issuer', 'letter_of_issuer');
            $table->string('ratio_information_on_use_of_proceeds')->nullable();

            // Rollback new columns
            $table->dropColumn('audited_financial_statements_due');
            $table->dropColumn('unaudited_financial_statements_due');
        });
    }
};
