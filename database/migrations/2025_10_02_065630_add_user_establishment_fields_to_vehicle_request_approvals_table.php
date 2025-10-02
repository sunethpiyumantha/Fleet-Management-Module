<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            // Add necessary fields (if not already present)
            $table->unsignedBigInteger('current_user_id')->nullable()->after('approved_by'); // Renamed from user_id to current_user_id - Link to the requesting user
            $table->unsignedBigInteger('initiated_by')->nullable()->after('current_user_id'); // Initial creator
            $table->integer('initiate_establishment_id')->nullable()->after('initiated_by'); // Auto-set from user's establishment_id
            $table->integer('current_establishment_id')->nullable()->after('initiate_establishment_id'); // Added new column for current establishment_id
            $table->foreign('current_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('initiated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('initiate_establishment_id')->references('e_id')->on('establishments')->onDelete('set null');
            $table->foreign('current_establishment_id')->references('e_id')->on('establishments')->onDelete('set null');

            // Add forwarding fields (keep as they are useful for workflow)
            $table->text('forward_reason')->nullable()->after('notes');
            $table->timestamp('forwarded_at')->nullable()->after('forward_reason');
            $table->unsignedBigInteger('forwarded_by')->nullable()->after('forwarded_at');
            $table->foreign('forwarded_by')->references('id')->on('users')->onDelete('set null');

            // Remove unnecessary fields (e.g., if user_id exists from previous, rename or drop; assuming no current_user_id redundancy)
            if (Schema::hasColumn('vehicle_request_approvals', 'user_id')) {
                $table->renameColumn('user_id', 'current_user_id'); // If user_id exists, rename it
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            // Reverse the changes
            $table->dropForeign(['current_user_id']);
            $table->dropForeign(['initiated_by']);
            $table->dropForeign(['initiate_establishment_id']);
            $table->dropForeign(['current_establishment_id']);
            $table->dropForeign(['forwarded_by']);
            $table->dropColumn(['current_user_id', 'initiated_by', 'initiate_establishment_id', 'current_establishment_id', 'forward_reason', 'forwarded_at', 'forwarded_by']);

            // Re-add if needed for rollback (reverse rename if applicable)
            if (!Schema::hasColumn('vehicle_request_approvals', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }
};