<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleColorsTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_colors', function (Blueprint $table) {
            $table->id();
            $table->string('color');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_colors');
    }
}