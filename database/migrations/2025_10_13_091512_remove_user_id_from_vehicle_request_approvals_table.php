<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            // Drop the foreign key constraint first (adjust name if custom)
            $table->dropForeign(['user_id']);
            
            // Then drop the column
            $table->dropColumn('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            // Add the column back (positioning optional)
            $table->unsignedBigInteger('user_id')->nullable()->after('approved_by'); // Adjust 'after' as needed
            
            // Re-add the foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
};