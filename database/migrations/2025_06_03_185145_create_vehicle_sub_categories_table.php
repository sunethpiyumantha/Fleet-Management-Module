<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vehicle_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('sub_category');
            $table->unique(['category', 'sub_category']); // Ensure unique category-sub_category pairs
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_sub_categories');
    }
};