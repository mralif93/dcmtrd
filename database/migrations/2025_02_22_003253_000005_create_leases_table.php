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
        Schema::create('leases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('lease_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('monthly_rent', 10, 2);
            $table->decimal('security_deposit', 10, 2);
            $table->decimal('pet_deposit', 10, 2)->nullable();
            $table->boolean('utilities_included')->default(false);
            $table->string('payment_frequency');
            $table->integer('late_fee_percentage');
            $table->integer('grace_period_days');
            $table->boolean('renewable')->default(true);
            $table->string('lease_term');
            $table->string('payment_method');
            $table->decimal('parking_fee', 8, 2)->nullable();
            $table->decimal('storage_fee', 8, 2)->nullable();
            $table->text('special_conditions')->nullable();
            $table->json('guarantor_info')->nullable();
            $table->date('move_in_inspection');
            $table->date('move_out_inspection')->nullable();
            $table->string('status');
            $table->string('termination_reason')->nullable();
            $table->string('notice_period');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};
