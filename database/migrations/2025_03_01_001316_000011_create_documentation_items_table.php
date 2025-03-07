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
        // Legal documentation items (section 1.0 in the images)
        Schema::create('documentation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_id')->constrained()->onDelete('cascade');
            $table->string('item_number'); // e.g., '1.1', '1.2'
            $table->string('document_type'); // e.g., 'Title', 'Trust Deed', etc.
            $table->text('description')->nullable();
            $table->date('validity_date')->nullable();
            $table->string('location')->nullable(); // e.g., 'LD's room'
            $table->boolean('is_prefilled')->default(false); // Indicates if LD has filled this before site visit
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentation_items');
    }
};
