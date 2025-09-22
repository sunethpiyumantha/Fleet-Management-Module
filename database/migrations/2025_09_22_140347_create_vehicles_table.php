<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->unsignedBigInteger('vehicle_type_id')->nullable();
            $table->unsignedBigInteger('vehicle_allocation_type_id')->nullable();
            $table->string('vehicle_army_no');
            $table->string('civil_no')->nullable();
            $table->string('chassis_no');
            $table->string('engine_no');
            $table->unsignedBigInteger('vehicle_make_id')->nullable();
            $table->unsignedBigInteger('vehicle_model_id')->nullable();
            $table->unsignedBigInteger('vehicle_category_id')->nullable();
            $table->unsignedBigInteger('vehicle_sub_category_id')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->string('current_vehicle_status')->nullable();
            $table->string('t5_location')->nullable();
            $table->string('parking_place')->nullable();
            $table->unsignedBigInteger('front_tire_size_id')->nullable();
            $table->unsignedBigInteger('rear_tire_size_id')->nullable();
            $table->unsignedBigInteger('engine_capacity_id')->nullable();
            $table->unsignedBigInteger('fuel_type_id')->nullable();
            $table->integer('seating_capacity')->nullable();
            $table->decimal('gross_weight', 8, 2)->nullable();
            $table->decimal('tare_weight', 8, 2)->nullable();
            $table->decimal('load_capacity', 8, 2)->nullable();
            $table->date('acquired_date')->nullable();
            $table->date('handover_date')->nullable();
            $table->string('part_x_no')->nullable();
            $table->string('part_x_location')->nullable();
            $table->date('part_x_date')->nullable();
            $table->date('insurance_period_from')->nullable();
            $table->date('insurance_period_to')->nullable();
            $table->string('emission_test_status')->nullable();
            $table->string('emission_test_year')->nullable();
            $table->unsignedBigInteger('workshop_id')->nullable();
            $table->unsignedBigInteger('admitted_workshop_id')->nullable();
            $table->date('workshop_admitted_date')->nullable();
            $table->date('service_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->string('fault')->nullable();
            $table->text('remarks')->nullable();
            $table->string('image_front')->nullable();
            $table->string('image_rear')->nullable();
            $table->string('image_side')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onDelete('set null');
            $table->foreign('vehicle_allocation_type_id')->references('id')->on('vehicle_allocation_types')->onDelete('set null');
            $table->foreign('vehicle_make_id')->references('id')->on('vehicle_makes')->onDelete('set null');
            $table->foreign('vehicle_model_id')->references('id')->on('vehicle_models')->onDelete('set null');
            $table->foreign('vehicle_category_id')->references('id')->on('vehicle_categories')->onDelete('set null');
            $table->foreign('vehicle_sub_category_id')->references('id')->on('vehicle_sub_categories')->onDelete('set null');
            $table->foreign('color_id')->references('id')->on('vehicle_colors')->onDelete('set null');
            $table->foreign('status_id')->references('id')->on('vehicle_statuses')->onDelete('set null');
            $table->foreign('front_tire_size_id')->references('id')->on('vehicle_tire_sizes')->onDelete('set null');
            $table->foreign('rear_tire_size_id')->references('id')->on('vehicle_tire_sizes')->onDelete('set null');
            $table->foreign('engine_capacity_id')->references('id')->on('vehicle_engine_capacities')->onDelete('set null');
            $table->foreign('fuel_type_id')->references('id')->on('fuel_types')->onDelete('set null');
            $table->foreign('workshop_id')->references('id')->on('workshops')->onDelete('set null');
            $table->foreign('admitted_workshop_id')->references('id')->on('workshops')->onDelete('set null');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}