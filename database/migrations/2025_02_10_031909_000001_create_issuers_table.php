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

            // Required Fields
            $table->string('issuer_short_name', 50)->unique();
            $table->string('issuer_name', 100);
            $table->bigInteger('registration_number')->unsigned()->unique();
            $table->date('trust_deed_date');
            
            // Optional Fields
            $table->string('debenture', 100)->nullable();
            $table->decimal('trustee_fee_amount_1', 15, 2)->nullable();
            $table->decimal('trustee_fee_amount_2', 15, 2)->nullable();
            $table->string('trustee_role_1', 100)->nullable();
            $table->string('trustee_role_2', 100)->nullable();
            $table->date('reminder_1')->nullable();
            $table->date('reminder_2')->nullable();
            $table->date('reminder_3')->nullable();
            
            // Timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('issuers');
    }
};