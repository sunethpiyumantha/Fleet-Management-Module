<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_declarations', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('registration_number');
            $table->string('owner_full_name');
            $table->string('owner_initials_name');
            $table->string('owner_permanent_address');
            $table->string('owner_temporary_address')->nullable();
            $table->string('owner_phone_number', 20);
            $table->string('owner_bank_details');
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types')->onDelete('restrict');
            $table->foreignId('vehicle_model_id')->constrained('vehicle_models')->onDelete('restrict');
            $table->integer('seats_registered');
            $table->integer('seats_current');
            $table->string('loan_tax_details')->nullable();
            $table->decimal('daily_rent', 10, 2);
            $table->date('induction_date');
            $table->string('civil_number');
            $table->string('product_classification');
            $table->string('engine_no');
            $table->string('chassis_number');
            $table->integer('year_of_manufacture');
            $table->date('date_of_original_registration');
            $table->foreignId('engine_capacity_id')->constrained('vehicle_engine_capacities')->onDelete('restrict');
            $table->string('section_4_w_2w');
            $table->integer('speedometer_hours');
            $table->string('code_no_vehicle');
            $table->foreignId('color_id')->constrained('vehicle_colors')->onDelete('restrict');
            $table->decimal('pay_per_day', 10, 2);
            $table->foreignId('fuel_type_id')->constrained('fuel_types')->onDelete('restrict');
            $table->string('tar_weight_capacity');
            $table->decimal('amount_of_fuel', 10, 2);
            $table->string('reason_for_taking_over');
            $table->string('other_matters')->nullable();
            $table->string('registration_certificate')->nullable();
            $table->string('insurance_certificate')->nullable();
            $table->string('revenue_license_certificate')->nullable();
            $table->string('owners_certified_nic')->nullable();
            $table->string('owners_certified_bank_passbook')->nullable();
            $table->string('suppliers_scanned_sign_document')->nullable();
            $table->string('affidavit_non_joint_account')->nullable();
            $table->string('affidavit_army_driver')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key to vehicle_requests
            $table->foreign('serial_number')->references('serial_number')->on('vehicle_requests')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_declarations');
    }
};