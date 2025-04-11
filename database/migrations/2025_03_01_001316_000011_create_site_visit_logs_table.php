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
        Schema::create('site_visit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_visit_id')->constrained()->onDelete('cascade');
            $table->integer('no');
            $table->date('visitation_date');
            $table->text('purpose');
            $table->date('report_submission_date')->nullable();
            $table->string('report_attachment')->nullable();
            $table->boolean('follow_up_required')->default(false);
            $table->text('remarks')->nullable();
            $table->string('status')->default('pending');
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('visitation_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_visit_logs');
    }
};