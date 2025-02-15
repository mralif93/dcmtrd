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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key
            $table->foreignId('issuer_id')->constrained('issuers')->onDelete('cascade');

            // Announcement Details
            $table->date('announcement_date');
            $table->string('category', 50); // e.g., "Dividend", "Financial Results"
            $table->string('sub_category', 50)->nullable(); // e.g., "Interim", "Final"
            $table->string('title', 200);
            $table->text('description');
            $table->longText('content'); // For large text content
            $table->string('attachment')->nullable(); // File path/URL
            $table->string('source', 100); // e.g., "Bursa Malaysia", "Company Website"

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index('announcement_date');
            $table->index(['category', 'sub_category']); // Composite index
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
