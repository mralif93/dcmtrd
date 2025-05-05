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
        Schema::create('report_batch_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_batch_id')->constrained('report_batches')->onDelete('cascade');
            // Core snapshot fields
            $table->string('bond_name')->nullable();        
            $table->string('facility_code')->nullable();           
            $table->string('issuer_short_name')->nullable();        
            $table->string('issuer_name')->nullable();                    
            $table->string('facility_name')->nullable();           
            $table->string('debenture_or_loan')->nullable();        
            $table->string('trustee_role_1')->nullable();          
            $table->string('trustee_role_2')->nullable();  

            // Financials
            $table->decimal('nominal_value', 18, 2)->nullable();     
            $table->decimal('outstanding_size', 18, 2)->nullable();  
            $table->decimal('trustee_fee_1', 18, 2)->nullable();     
            $table->decimal('trustee_fee_2', 18, 2)->nullable();     

            // Dates
            $table->date('trust_deed_date')->nullable();            
            $table->date('issue_date')->nullable();                 
            $table->date('maturity_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_batch_items');
    }
};
