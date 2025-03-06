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
        // Condition checks (sections 3.0 and 4.0 in the images)
        Schema::create('condition_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_id')->constrained()->onDelete('cascade');
            $table->string('section'); // 'External Area', 'Internal Area'
            $table->string('item_number'); // e.g., '3.1', '4.2'
            $table->string('item_name'); // e.g., 'General Cleanliness', 'Fencing & Main Gate'
            $table->boolean('is_satisfied')->default(false);
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('condition_checks');
    }
};
