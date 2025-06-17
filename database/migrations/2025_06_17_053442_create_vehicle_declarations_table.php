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
        Schema::create('vehicle_declarations', function (Blueprint $table) {
            $table->id();
            
            // Owner Section
            $table->string('registration_number');
            $table->string('owner_full_name');
            $table->string('owner_initials_name');
            $table->text('owner_permanent_address');
            $table->text('owner_temporary_address')->nullable();
            $table->string('owner_phone_number');
            $table->text('owner_bank_details');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->unsignedBigInteger('vehicle_model_id');
            $table->integer('seats_registered');
            $table->integer('seats_current');
            $table->string('registration_certificate')->nullable(); // file path
            $table->string('insurance_certificate')->nullable(); // file path
            $table->text('loan_tax_details')->nullable();
            $table->decimal('daily_rent', 10, 2);
            $table->date('induction_date');
            
            // Driver Section
            $table->string('owner_next_of_kin');
            $table->string('driver_full_name');
            $table->text('driver_address');
            $table->string('driver_license_number');
            $table->string('driver_nic_number');
            $table->string('driver_next_of_kin');
            
            // Additional Documents
            $table->string('document_1')->nullable(); // file path
            $table->string('document_2')->nullable(); // file path
            $table->string('document_3')->nullable(); // file path
            $table->string('document_4')->nullable(); // file path
            
            $table->timestamps();
            $table->softDeletes(); // This adds deleted_at column for soft delete
            
            // Foreign key constraints
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types');
            $table->foreign('vehicle_model_id')->references('id')->on('vehicle_models');
            
            // Indexes
            $table->index('registration_number');
            $table->index('vehicle_type_id');
            $table->index('vehicle_model_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_declarations');
    }
};