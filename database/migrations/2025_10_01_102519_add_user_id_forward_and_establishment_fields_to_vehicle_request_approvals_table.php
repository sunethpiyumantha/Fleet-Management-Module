<?php
// database/migrations/2025_10_01_102519_add_user_id_forward_and_establishment_fields_to_vehicle_request_approvals_table.php

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
            // Skip user_id as it already exists
            $table->foreignId('initiated_establishment_id')->nullable()->constrained('establishments')->onDelete('cascade')->after('user_id');
            $table->foreignId('current_establishment_id')->nullable()->constrained('establishments')->onDelete('cascade')->after('initiated_establishment_id');
            $table->text('forward_reason')->nullable()->after('notes');
            $table->timestamp('forwarded_at')->nullable()->after('forward_reason');
            $table->foreignId('forwarded_by')->nullable()->constrained('users')->onDelete('set null')->after('forwarded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            // Skip user_id as it already exists (don't drop it)
            $table->dropForeign(['initiated_establishment_id']);
            $table->dropForeign(['current_establishment_id']);
            $table->dropForeign(['forwarded_by']);
            $table->dropColumn(['initiated_establishment_id', 'current_establishment_id', 'forward_reason', 'forwarded_at', 'forwarded_by']);
        });
    }
};