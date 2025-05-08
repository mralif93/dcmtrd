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
        Schema::table('compliance_covenants', function (Blueprint $table) {
            $table->boolean('cc_not_required')->nullable()->after('compliance_certificate');
            $table->boolean('afs_not_required')->nullable()->after('audited_financial_statements');
            $table->boolean('ufs_not_required')->nullable()->after('unaudited_financial_statements');
            $table->boolean('fscr_not_required')->nullable()->after('finance_service_cover_ratio');
            $table->boolean('budget_not_required')->nullable()->after('annual_budget');
            $table->boolean('ebitda_not_required')->nullable()->after('computation_of_finance_to_ebitda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compliance_covenants', function (Blueprint $table) {
            $table->dropColumn([
                'cc_not_required',
                'afs_not_required',
                'ufs_not_required',
                'fscr_not_required',
                'budget_not_required',
                'ebitda_not_required',
            ]);
        });
    }
};
