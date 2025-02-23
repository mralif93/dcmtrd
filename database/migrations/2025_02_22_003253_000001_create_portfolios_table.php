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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->text('description');
            $table->date('foundation_date');
            $table->decimal('total_assets', 15, 2);
            $table->decimal('market_cap', 15, 2);
            $table->decimal('available_funds', 15, 2);
            $table->string('management_company');
            $table->string('legal_entity_type');
            $table->string('tax_id');
            $table->string('currency');
            $table->string('risk_profile');
            $table->decimal('target_return', 8, 2);
            $table->string('investment_strategy');
            $table->string('portfolio_manager');
            $table->date('fiscal_year_end');
            $table->boolean('active_status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};