<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicle_tire_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('front_tire_size');
            $table->string('rear_tire_size');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_tire_sizes');
    }
};