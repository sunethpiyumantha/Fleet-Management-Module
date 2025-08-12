<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicle_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_request_id')->constrained()->onDelete('cascade');
            $table->string('serial_number');
            $table->string('request_type');
            $table->string('engine_number');
            $table->string('chassis_number');
            $table->string('engine_performance');
            $table->string('electrical_system');
            $table->string('transmission_system');
            $table->string('tires');
            $table->string('brake_system');
            $table->string('suspension_system');
            $table->string('air_conditioning');
            $table->string('seats_condition');
            $table->string('fuel_efficiency');
            $table->string('speedometer_reading');
            $table->string('speedometer_operation');
            $table->string('running_distance_function');
            $table->text('improvements');
            $table->string('transmission_operation');
            $table->string('battery_type');
            $table->string('battery_capacity');
            $table->string('battery_number');
            $table->string('water_capacity')->nullable();
            $table->string('cover_outer');
            $table->string('certificate_validity');
            $table->string('seats_mvr');
            $table->string('seats_installed');
            $table->text('other_matters')->nullable();
            $table->string('vehicle_picture')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_certificates');
    }
};