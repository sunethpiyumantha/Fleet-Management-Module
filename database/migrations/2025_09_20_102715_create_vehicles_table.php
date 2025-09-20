<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('request_type')->nullable();
            $table->string('vehicle_type');
            $table->string('vehicle_allocation_type');
            $table->string('vehicle_army_no');
            $table->string('civil_no');
            $table->string('chassis_no');
            $table->string('engine_no');
            $table->string('vehicle_make');
            $table->string('vehicle_model');
            $table->string('vehicle_category');
            $table->string('vehicle_sub_category');
            $table->string('color');
            $table->string('status');
            $table->string('current_vehicle_status');
            $table->string('t5_location');
            $table->string('parking_place');
            $table->string('front_tire_size');
            $table->string('rear_tire_size');
            $table->string('engine_capacity');
            $table->string('fuel_type');
            $table->string('seating_capacity');
            $table->string('gross_weight');
            $table->string('tare_weight');
            $table->string('load_capacity');
            $table->date('acquired_date');
            $table->date('handover_date');
            $table->string('part_x_no');
            $table->string('part_x_location');
            $table->date('part_x_date');
            $table->date('insurance_period_from');
            $table->date('insurance_period_to');
            $table->string('emission_test_status');
            $table->string('emission_test_year');
            $table->string('workshop');
            $table->string('admitted_workshop');
            $table->date('workshop_admitted_date');
            $table->string('service_date')->nullable();
            $table->string('next_service_date')->nullable();
            $table->string('driver');
            $table->string('fault');
            $table->text('remarks')->nullable();
            $table->string('image_front')->nullable();
            $table->string('image_rear')->nullable();
            $table->string('image_side')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};