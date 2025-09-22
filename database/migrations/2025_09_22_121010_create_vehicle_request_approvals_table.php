<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_request_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('request_type'); // 'replacement' or 'new_approval'
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->integer('quantity')->default(1);
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('vehicle_letter')->nullable(); // file path
            $table->text('notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();

            // Foreign keys - Updated to match your existing table structure
            $table->foreign('category_id')->references('id')->on('vehicle_categories')->onDelete('restrict');
            $table->foreign('sub_category_id')->references('id')->on('vehicle_sub_categories')->onDelete('restrict');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_request_approvals');
    }
};