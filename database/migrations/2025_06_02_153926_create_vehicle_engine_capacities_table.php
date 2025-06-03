<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vehicle_engine_capacities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('engine_capacity')->unique();
            $table->timestamps();        // adds created_at and updated_at
            $table->softDeletes();       // adds deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_engine_capacities');
    }
};
