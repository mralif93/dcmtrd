<?php

use App\Models\ListSecurity;
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
        Schema::create('security_doc_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ListSecurity::class)->constrained()->onDelete('cascade');
            $table->string('purpose')->nullable();
            $table->date('request_date')->nullable();
            $table->string('status')->nullable();
            $table->date('withdrawal_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_doc_requests');
    }
};
