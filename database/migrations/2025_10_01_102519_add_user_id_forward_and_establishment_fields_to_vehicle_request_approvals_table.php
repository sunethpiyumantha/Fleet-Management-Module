<?php
// database/migrations/2025_10_01_102519_add_user_id_forward_and_establishment_fields_to_vehicle_request_approvals_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicle_request_approvals', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->after('quantity');
            }

            if (!Schema::hasColumn('vehicle_request_approvals', 'initiate_establishment_id')) { // Standardized to match model
                $table->unsignedBigInteger('initiate_establishment_id')->nullable()->index()->after('user_id');
                $table->foreign('initiate_establishment_id')->references('e_id')->on('establishments')->onDelete('cascade');
            }

            if (!Schema::hasColumn('vehicle_request_approvals', 'current_establishment_id')) {
                $table->unsignedBigInteger('current_establishment_id')->nullable()->index()->after('initiate_establishment_id');
                $table->foreign('current_establishment_id')->references('e_id')->on('establishments')->onDelete('cascade');
            }

            if (!Schema::hasColumn('vehicle_request_approvals', 'forward_reason')) {
                $table->text('forward_reason')->nullable()->after('notes');
            }

            if (!Schema::hasColumn('vehicle_request_approvals', 'forwarded_at')) {
                $table->timestamp('forwarded_at')->nullable()->after('forward_reason');
            }

            if (!Schema::hasColumn('vehicle_request_approvals', 'forwarded_by')) {
                $table->foreignId('forwarded_by')->nullable()->constrained('users')->onDelete('set null')->after('forwarded_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            // Drop columns only if they exist
            if (Schema::hasColumn('vehicle_request_approvals', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'initiate_establishment_id')) {
                $table->dropForeign(['initiate_establishment_id']);
                $table->dropColumn('initiate_establishment_id');
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'current_establishment_id')) {
                $table->dropForeign(['current_establishment_id']);
                $table->dropColumn('current_establishment_id');
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'forward_reason')) {
                $table->dropColumn('forward_reason');
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'forwarded_at')) {
                $table->dropColumn('forwarded_at');
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'forwarded_by')) {
                $table->dropForeign(['forwarded_by']);
                $table->dropColumn('forwarded_by');
            }
        });

        // Safely drop foreign keys using raw SQL if they exist (MySQL supports IF EXISTS)
        DB::statement('ALTER TABLE vehicle_request_approvals DROP FOREIGN KEY IF EXISTS `vehicle_request_approvals_user_id_foreign`');
        DB::statement('ALTER TABLE vehicle_request_approvals DROP FOREIGN KEY IF EXISTS `vehicle_request_approvals_initiate_establishment_id_foreign`');
        DB::statement('ALTER TABLE vehicle_request_approvals DROP FOREIGN KEY IF EXISTS `vehicle_request_approvals_current_establishment_id_foreign`');
        DB::statement('ALTER TABLE vehicle_request_approvals DROP FOREIGN KEY IF EXISTS `vehicle_request_approvals_forwarded_by_foreign`');
    }
};