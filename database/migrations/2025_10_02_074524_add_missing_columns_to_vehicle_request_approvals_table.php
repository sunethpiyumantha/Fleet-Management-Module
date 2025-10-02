<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            // Conditionally add missing columns (prevents duplicates)
            if (!Schema::hasColumn('vehicle_request_approvals', 'current_user_id')) {
                $table->unsignedBigInteger('current_user_id')->nullable()->after('quantity');
                $table->foreign('current_user_id')->references('id')->on('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('vehicle_request_approvals', 'initiated_by')) {
                $table->unsignedBigInteger('initiated_by')->nullable()->after('current_user_id');
                $table->foreign('initiated_by')->references('id')->on('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('vehicle_request_approvals', 'initiate_establishment_id')) {
                $table->unsignedBigInteger('initiate_establishment_id')->nullable()->after('initiated_by');  // Use unsignedBigInteger for consistency with e_id if it's bigint
                $table->foreign('initiate_establishment_id')->references('e_id')->on('establishments')->onDelete('set null');
            }

            if (!Schema::hasColumn('vehicle_request_approvals', 'current_establishment_id')) {
                $table->unsignedBigInteger('current_establishment_id')->nullable()->after('initiate_establishment_id');
                $table->foreign('current_establishment_id')->references('e_id')->on('establishments')->onDelete('set null');
            }

            if (!Schema::hasColumn('vehicle_request_approvals', 'forward_reason')) {
                $table->text('forward_reason')->nullable()->after('current_establishment_id');
            }

            if (!Schema::hasColumn('vehicle_request_approvals', 'forwarded_at')) {
                $table->timestamp('forwarded_at')->nullable()->after('forward_reason');
            }

            if (!Schema::hasColumn('vehicle_request_approvals', 'forwarded_by')) {
                $table->unsignedBigInteger('forwarded_by')->nullable()->after('forwarded_at');
                $table->foreign('forwarded_by')->references('id')->on('users')->onDelete('set null');
            }

            // Handle potential rename if user_id exists and current_user_id doesn't (from older migrations)
            if (Schema::hasColumn('vehicle_request_approvals', 'user_id') && !Schema::hasColumn('vehicle_request_approvals', 'current_user_id')) {
                $table->renameColumn('user_id', 'current_user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            // Drop foreign keys first (use dynamic names if needed; adjust based on your DB)
            $table->dropForeign(['current_user_id']);
            $table->dropForeign(['initiated_by']);
            $table->dropForeign(['initiate_establishment_id']);
            $table->dropForeign(['current_establishment_id']);
            $table->dropForeign(['forwarded_by']);

            // Drop columns only if they exist
            if (Schema::hasColumn('vehicle_request_approvals', 'current_user_id')) {
                $table->dropColumn('current_user_id');
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'initiated_by')) {
                $table->dropColumn('initiated_by');
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'initiate_establishment_id')) {
                $table->dropColumn('initiate_establishment_id');
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'current_establishment_id')) {
                $table->dropColumn('current_establishment_id');
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'forward_reason')) {
                $table->dropColumn('forward_reason');
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'forwarded_at')) {
                $table->dropColumn('forwarded_at');
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'forwarded_by')) {
                $table->dropColumn('forwarded_by');
            }

            // Reverse rename if applicable
            if (!Schema::hasColumn('vehicle_request_approvals', 'user_id') && Schema::hasColumn('vehicle_request_approvals', 'current_user_id')) {
                $table->renameColumn('current_user_id', 'user_id');
            }
        });
    }
};