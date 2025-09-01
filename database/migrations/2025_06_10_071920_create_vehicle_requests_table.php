<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicle_requests', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique()->nullable();
            $table->string('request_type');
            $table->foreignId('cat_id')->constrained('vehicle_categories')->onDelete('cascade');
            $table->foreignId('sub_cat_id')->constrained('vehicle_sub_categories')->onDelete('cascade');
            $table->integer('qty');
            $table->date('date_submit')->nullable();
            $table->string('status')->nullable();
            $table->string('vehicle_book_path')->nullable();
            $table->string('image_01_path')->nullable();
            $table->string('image_02_path')->nullable();
            $table->string('image_03_path')->nullable();
            $table->string('image_04_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_requests');
    }
};