<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_statuses');
    }
}