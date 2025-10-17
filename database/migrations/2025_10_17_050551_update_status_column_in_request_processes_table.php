<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('request_processes', function (Blueprint $table) {
            // Modify the status ENUM to include all required values
            $table->enum('status', ['pending', 'approved', 'rejected', 'forwarded', 'reforwarded'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_processes', function (Blueprint $table) {
            // Revert to the original ENUM values
            $table->enum('status', ['pending', 'approved', 'rejected', 'forwarded'])->default('pending')->change();
        });
    }
};