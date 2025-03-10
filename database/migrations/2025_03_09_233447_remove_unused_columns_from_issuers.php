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
        Schema::table('issuers', function (Blueprint $table) {
            $table->dropColumn([
                'debenture',
                'trustee_fee_amount_1',
                'trustee_fee_amount_2',
                'trustee_role_1',
                'trustee_role_2',
                'reminder_1',
                'reminder_2',
                'reminder_3',
                'trust_deed_date'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issuers', function (Blueprint $table) {
            $table->string('debenture')->nullable();
            $table->decimal('trustee_fee_amount_1', 15, 2)->nullable();
            $table->decimal('trustee_fee_amount_2', 15, 2)->nullable();
            $table->string('trustee_role_1')->nullable();
            $table->string('trustee_role_2')->nullable();
            $table->date('reminder_1')->nullable();
            $table->date('reminder_2')->nullable();
            $table->date('reminder_3')->nullable();
            $table->date('trust_deed_date')->nullable();
        });
    }
};
