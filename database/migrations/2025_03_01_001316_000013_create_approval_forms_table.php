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

            // foreign key to portfolios table
            $table->foreignId('portfolio_id')->nullable()->constrained()->onDelete('cascade');
            // foreign key to properties table
            $table->foreignId('property_id')->nullable()->constrained()->onDelete('cascade');

            // form details
            $table->string('category')->nullable();
            $table->text('details')->nullable();
            $table->date('received_date');
            $table->date('send_date')->nullable();
            $table->string('attachment')->nullable();

            // system information
            $table->string('status')->default('pending');
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();

            // default information
            $table->timestamps();
            $table->softDeletes();
            
            // Add indexes for better performance
            $table->index(['category', 'received_date', 'send_date']);
            $table->index(['portfolio_id', 'property_id']);
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