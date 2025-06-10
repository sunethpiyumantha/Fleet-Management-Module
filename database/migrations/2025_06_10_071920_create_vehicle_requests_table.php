<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cat_id')->constrained('vehicle_categories')->onDelete('cascade');
            $table->foreignId('sub_cat_id')->constrained('vehicle_sub_categories')->onDelete('cascade');
            $table->integer('required_quantity');
            $table->date('date_submit');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_requests');
    }
}