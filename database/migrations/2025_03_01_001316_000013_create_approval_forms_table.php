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
        Schema::create('approval_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->nullable()->constrained()->onDelete('set null');
            $table->string('category')->nullable();
            $table->text('details')->nullable();
            $table->date('received_date');
            $table->date('send_date')->nullable();
            $table->string('attachment')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->default('pending');
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes for better performance
            $table->index(['form_title', 'received_date', 'send_date']);
            $table->index('form_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_forms');
    }
};