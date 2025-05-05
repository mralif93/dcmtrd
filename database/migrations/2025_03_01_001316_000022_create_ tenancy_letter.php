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
        Schema::create('tenancy_letter', function (Blueprint $table) {
            $table->id();

            // Foreign key to the lease table
            $table->foreignId('lease_id')->constrained()->onDelete('cascade');
            
            // Letter reference information
            $table->string('your_reference')->nullable();
            $table->string('our_reference')->nullable();
            $table->date('letter_date')->nullable();

            // Recipient information
            $table->string('recipient_company')->nullable();
            $table->text('recipient_address')->nullable();
            $table->string('attention_to_name')->nullable();
            $table->string('attention_to_position')->nullable();

            // Approver information
            $table->string('trustee_name')->nullable();
            $table->string('approver_name')->nullable();
            $table->string('approver_position')->nullable();
            $table->string('approver_department')->nullable();
        
            // System information
            $table->string('status')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('approval_datetime')->nullable();
        
            // Default fields
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenancy_letter');
    }
};