<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('army_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique()->nullable();
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types')->onDelete('cascade');
            $table->foreignId('vehicle_allocation_type_id')->constrained('vehicle_allocation_types')->onDelete('cascade');
            $table->string('vehicle_army_no')->unique();
            $table->string('civil_no')->nullable();
            $table->string('chassis_no');
            $table->string('engine_no');
            $table->foreignId('vehicle_make_id')->constrained('vehicle_makes')->onDelete('cascade');
            $table->foreignId('vehicle_model_id')->constrained('vehicle_models')->onDelete('cascade');
            $table->foreignId('vehicle_category_id')->constrained('vehicle_categories')->onDelete('cascade');
            $table->foreignId('vehicle_sub_category_id')->constrained('vehicle_sub_categories')->onDelete('cascade');
            $table->foreignId('color_id')->constrained('vehicle_colors')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('vehicle_statuses')->onDelete('cascade');
            $table->enum('current_vehicle_status', ['on_road', 'off_road']);
            $table->string('t5_location')->nullable();
            $table->string('parking_place')->nullable();
            $table->foreignId('front_tire_size_id')->constrained('vehicle_tire_sizes')->onDelete('cascade');
            $table->foreignId('rear_tire_size_id')->constrained('vehicle_tire_sizes')->onDelete('cascade');
            $table->foreignId('engine_capacity_id')->constrained('vehicle_engine_capacities')->onDelete('cascade');
            $table->foreignId('fuel_type_id')->constrained('fuel_types')->onDelete('cascade');
            $table->integer('seating_capacity')->nullable();
            $table->decimal('gross_weight', 10, 2)->nullable();
            $table->decimal('tare_weight', 10, 2)->nullable();
            $table->decimal('load_capacity', 10, 2)->nullable();
            $table->date('acquired_date')->nullable();
            $table->date('handover_date')->nullable();
            $table->string('part_x_no')->nullable();
            $table->string('part_x_location')->nullable();
            $table->date('part_x_date')->nullable();
            $table->date('insurance_period_from')->nullable();
            $table->date('insurance_period_to')->nullable();
            $table->enum('emission_test_status', ['yes', 'no'])->nullable();
            $table->integer('emission_test_year')->nullable();
            $table->foreignId('workshop_id')->nullable()->constrained('workshops')->onDelete('set null');
            $table->foreignId('admitted_workshop_id')->nullable()->constrained('workshops')->onDelete('set null');
            $table->date('workshop_admitted_date')->nullable();
            $table->date('service_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->text('fault')->nullable();
            $table->text('remarks')->nullable();
            $table->string('image_front')->nullable();
            $table->string('image_rear')->nullable();
            $table->string('image_side')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('army_vehicles');
    }
};