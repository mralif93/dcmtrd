<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('issuers', function (Blueprint $table) {
            $table->id();
            $table->string('issuer_short_name');
            $table->string('issuer_name');
            $table->string('registration_number')->unique();
            $table->string('debenture')->nullable();
            $table->decimal('trustee_fee_amount_1', 15, 2)->nullable();
            $table->decimal('trustee_fee_amount_2', 15, 2)->nullable();
            $table->string('trustee_role_1')->nullable();
            $table->string('trustee_role_2')->nullable();
            $table->date('reminder_1')->nullable();
            $table->date('reminder_2')->nullable();
            $table->date('reminder_3')->nullable();
            $table->date('trust_deed_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('issuers');
    }
};