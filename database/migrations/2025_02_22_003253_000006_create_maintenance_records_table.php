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
        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('request_type');
            $table->text('description');
            $table->string('reported_by');
            $table->date('request_date');
            $table->date('scheduled_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->time('estimated_time');
            $table->time('actual_time')->nullable();
            $table->decimal('estimated_cost', 10, 2);
            $table->decimal('actual_cost', 10, 2)->nullable();
            $table->string('contractor_name')->nullable();
            $table->string('contractor_contact')->nullable();
            $table->string('work_order_number');
            $table->string('priority');
            $table->string('category');
            $table->json('materials_used')->nullable();
            $table->text('warranty_info')->nullable();
            $table->json('images')->nullable();
            $table->text('notes')->nullable();
            $table->string('assigned_to');
            $table->string('approval_status');
            $table->string('status');
            $table->boolean('recurring')->default(false);
            $table->integer('recurrence_interval')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_records');
    }
};
