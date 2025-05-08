<?php

use App\Models\Issuer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('list_securities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Issuer::class)->constrained()->onDelete('cascade');
            $table->string('security_name');
            $table->string('security_code'); 
            $table->string('asset_name_type');

            // System information
            $table->string('status')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_securities');
    }
};
