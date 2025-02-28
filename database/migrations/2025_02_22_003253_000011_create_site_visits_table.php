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
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('visitor_name');
            $table->string('visitor_email');
            $table->string('visitor_phone');
            $table->dateTime('visit_date');
            $table->dateTime('actual_visit_start')->nullable();
            $table->dateTime('actual_visit_end')->nullable();
            $table->string('visit_type'); // First Visit, Second Visit, Final Visit
            $table->string('visit_status'); // Scheduled, Completed, Cancelled, No-Show
            $table->string('conducted_by'); // Agent Name
            $table->text('visitor_feedback')->nullable();
            $table->text('agent_notes')->nullable();
            $table->boolean('interested')->default(false);
            $table->decimal('quoted_price', 10, 2)->nullable();
            $table->json('requirements')->nullable();
            $table->string('source'); // Website, Referral, Agent, etc.
            $table->boolean('follow_up_required')->default(false);
            $table->date('follow_up_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_visits');
    }
};
