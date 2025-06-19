<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleDeclarationsTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_declarations', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->nullable()->unique();
            // Owner Details
            $table->string('registration_number')->unique();
            $table->string('owner_full_name');
            $table->string('owner_initials_name');
            $table->string('owner_permanent_address');
            $table->string('owner_temporary_address')->nullable();
            $table->string('owner_phone_number');
            $table->string('owner_bank_details');
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types');
            $table->foreignId('vehicle_model_id')->constrained('vehicle_models');
            $table->integer('seats_registered');
            $table->integer('seats_current');
            $table->string('loan_tax_details')->nullable();
            $table->decimal('daily_rent', 10, 2);
            $table->date('induction_date');
            // Driver Details
            $table->string('owner_next_of_kin');
            $table->string('driver_full_name');
            $table->string('driver_address');
            $table->string('driver_license_number');
            $table->string('driver_nic_number');
            $table->string('driver_next_of_kin');
            // Vehicle Details
            $table->string('civil_number');
            $table->string('product_classification');
            $table->string('engine_no');
            $table->string('chassis_number');
            $table->integer('year_of_manufacture');
            $table->date('date_of_original_registration');
            $table->string('engine_capacity');
            $table->string('section_4_w_2w');
            $table->integer('speedometer_hours');
            $table->string('code_no');
            $table->string('color');
            $table->decimal('pay_per_day', 10, 2);
            $table->string('type_of_fuel');
            $table->string('tar_weight_capacity');
            $table->decimal('amount_of_fuel', 10, 2);
            $table->string('reason_for_taking_over');
            $table->string('other_matters')->nullable();
            // Document Paths
            $table->string('registration_certificate_path');
            $table->string('insurance_certificate_path');
            $table->string('revenue_license_certificate_path')->nullable();
            $table->string('owners_certified_nic_path')->nullable();
            $table->string('owners_certified_bank_passbook_path')->nullable();
            $table->string('suppliers_scanned_sign_document_path')->nullable();
            $table->string('affidavit_non_joint_account_path')->nullable();
            $table->string('affidavit_army_driver_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_declarations');
    }
}