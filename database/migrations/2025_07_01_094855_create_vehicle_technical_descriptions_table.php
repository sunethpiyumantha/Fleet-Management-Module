<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTechnicalDescriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_technical_descriptions', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number');
            $table->string('gross_weight');
            $table->string('seats_sleme');
            $table->string('comparable');
            $table->string('seats_mvr');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_technical_descriptions');
    }
}