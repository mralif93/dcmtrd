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
            $table->string('pic_name')->nullable()->after('issuer_name'); // Add PIC Name
            $table->string('phone_no')->nullable()->after('pic_name'); // Add Phone Number
            $table->text('address')->nullable()->after('phone_no'); // Add Address
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issuers', function (Blueprint $table) {
            $table->dropColumn(['pic_name', 'phone_no', 'address']);
        });
    }
};
