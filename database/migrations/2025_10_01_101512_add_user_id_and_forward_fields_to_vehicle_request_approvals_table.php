<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_user_id_and_forward_fields_to_vehicle_request_approvals_table.php

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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->after('quantity');
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
            $table->dropForeign(['user_id']);
            $table->dropForeign(['forwarded_by']);
            $table->dropColumn(['user_id', 'forward_reason', 'forwarded_at', 'forwarded_by']);
        });
    }
};