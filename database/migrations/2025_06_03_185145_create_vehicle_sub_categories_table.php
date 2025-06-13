<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleSubCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cat_id')->constrained('vehicle_categories')->onDelete('cascade');
            $table->string('sub_category');
            $table->timestamps();
            $table->unique(['cat_id', 'sub_category'], 'vehicle_sub_categories_cat_id_sub_category_unique');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_sub_categories');
    }
}