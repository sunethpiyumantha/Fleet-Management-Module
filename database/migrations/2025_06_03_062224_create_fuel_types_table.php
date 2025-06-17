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
        Schema::create('fuel_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serial_number')->nullable()->unique();
            $table->string('fuel_type')->unique();
            $table->timestamps();        // Adds created_at and updated_at
            $table->softDeletes();       // Adds deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_types');
    }
};
