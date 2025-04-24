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

            // issuer details
            $table->string('issuer_short_name');
            $table->string('issuer_name');
            $table->string('registration_number')->unique();
            $table->string('debenture')->nullable();
            $table->string('trustee_role_1')->nullable();
            $table->string('trustee_role_2')->nullable();
            $table->date('trust_deed_date')->nullable();
            $table->string('trust_amount_escrow_sum')->nullable();
            $table->string('no_of_share')->nullable();
            $table->string('outstanding_size')->nullable();

            // system information
            $table->string('status')->default('Draft')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();

            // default information
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('issuers');
    }
};