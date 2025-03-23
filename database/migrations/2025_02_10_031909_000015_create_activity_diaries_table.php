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
        Schema::create('activity_diaries', function (Blueprint $table) {
            $table->id();
            $table->text('purpose')->nullable();
            $table->date('letter_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('extension_date_1')->nullable();
            $table->string('extension_note_1')->nullable();
            $table->date('extension_date_2')->nullable();
            $table->string('extension_note_2')->nullable();
            $table->string('status')->nullable();
            $table->text('remarks')->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->dateTime('approval_datetime')->nullable();
            $table->foreignId('issuer_id')->constrained('issuers')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_diaries');
    }
};