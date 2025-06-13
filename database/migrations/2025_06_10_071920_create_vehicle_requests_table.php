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
            $table->string('request_type');
            $table->unsignedBigInteger('cat_id');
            $table->unsignedBigInteger('sub_cat_id');
            $table->integer('qty');
            $table->date('date_submit')->default(now());
            $table->string('status')->default('pending');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cat_id')->references('id')->on('vehicle_categories')->onDelete('cascade');
            $table->foreign('sub_cat_id')->references('id')->on('vehicle_sub_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_requests');
    }
}