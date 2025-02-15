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
        Schema::create('related_documents', function (Blueprint $table) {
            $table->id();

            // Foreign Key
            $table->foreignId('facility_id')->constrained('facility_informations')->onDelete('cascade');

            $table->string('document_name', 200);
            $table->string('document_type', 50); // Consider enum for fixed types (e.g., PDF, XLS)
            $table->date('upload_date');
            $table->string('file_path', 500); // Increased length for file paths
            
            // Timestamp
            $table->timestamps();
            
            // Indexes
            $table->index('document_type');
            $table->index('upload_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('related_documents');
    }
};
