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
        Schema::create('site_visit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('visit_day')->nullable();
            $table->string('visit_month')->nullable();
            $table->string('visit_year')->nullable();
            $table->text('purpose')->nullable();
            $table->text('remarks')->nullable();
            $table->string('category')->nullable();
            $table->string('status')->default('pending');
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['visit_year', 'visit_month', 'visit_day']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_visit_logs');
    }
};