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
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            $table->string('vehicle_type')->nullable(); // 'army' or 'hired'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            $table->dropColumn('vehicle_type');
        });
    }
};