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
            $table->string('document_name');
            $table->string('document_type');
            $table->date('upload_date');
            $table->string('file_path')->nullable();;
            $table->foreignId('facility_id')->constrained('facility_informations')->onDelete('cascade');
            $table->timestamps();
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
