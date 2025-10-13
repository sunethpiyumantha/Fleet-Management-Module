<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            // Get current table definition to check for existing constraints
            $tableDefinition = DB::select("SHOW CREATE TABLE vehicle_request_approvals")[0]->{'Create Table'};

            // Rename user_id to current_user_id if user_id exists and current_user_id does not
            if (Schema::hasColumn('vehicle_request_approvals', 'user_id') && !Schema::hasColumn('vehicle_request_approvals', 'current_user_id')) {
                $table->renameColumn('user_id', 'current_user_id');
                // Re-add foreign key after rename if needed
                if (!str_contains($tableDefinition, 'vehicle_request_approvals_current_user_id_foreign')) {
                    $table->foreign('current_user_id')->references('id')->on('users')->onDelete('cascade');
                }
            }

            // Add initiated_by if not present (after current_user_id, which may be renamed)
            if (!Schema::hasColumn('vehicle_request_approvals', 'initiated_by')) {
                $table->unsignedBigInteger('initiated_by')->nullable()->after('current_user_id');
                if (!str_contains($tableDefinition, 'vehicle_request_approvals_initiated_by_foreign')) {
                    $table->foreign('initiated_by')->references('id')->on('users')->onDelete('set null');
                }
            }

            // Add initiate_establishment_id if not present (standardized name, after initiated_by)
            if (!Schema::hasColumn('vehicle_request_approvals', 'initiate_establishment_id')) {
                $table->unsignedBigInteger('initiate_establishment_id')->nullable()->index()->after('initiated_by');
                if (!str_contains($tableDefinition, 'vehicle_request_approvals_initiate_establishment_id_foreign')) {
                    $table->foreign('initiate_establishment_id')->references('e_id')->on('establishments')->onDelete('set null');
                }
            }

            // Add current_establishment_id if not present (after initiate_establishment_id)
            if (!Schema::hasColumn('vehicle_request_approvals', 'current_establishment_id')) {
                $table->unsignedBigInteger('current_establishment_id')->nullable()->index()->after('initiate_establishment_id');
                if (!str_contains($tableDefinition, 'vehicle_request_approvals_current_establishment_id_foreign')) {
                    $table->foreign('current_establishment_id')->references('e_id')->on('establishments')->onDelete('set null');
                }
            }

            // Add forwarding fields if not present
            if (!Schema::hasColumn('vehicle_request_approvals', 'forward_reason')) {
                $table->text('forward_reason')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('vehicle_request_approvals', 'forwarded_at')) {
                $table->timestamp('forwarded_at')->nullable()->after('forward_reason');
            }
            if (!Schema::hasColumn('vehicle_request_approvals', 'forwarded_by')) {
                $table->unsignedBigInteger('forwarded_by')->nullable()->after('forwarded_at');
                if (!str_contains($tableDefinition, 'vehicle_request_approvals_forwarded_by_foreign')) {
                    $table->foreign('forwarded_by')->references('id')->on('users')->onDelete('set null');
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            // Safe drop foreign keys using raw SQL if they exist
            DB::statement('ALTER TABLE vehicle_request_approvals DROP FOREIGN KEY IF EXISTS `vehicle_request_approvals_current_user_id_foreign`');
            DB::statement('ALTER TABLE vehicle_request_approvals DROP FOREIGN KEY IF EXISTS `vehicle_request_approvals_initiated_by_foreign`');
            DB::statement('ALTER TABLE vehicle_request_approvals DROP FOREIGN KEY IF EXISTS `vehicle_request_approvals_initiate_establishment_id_foreign`');
            DB::statement('ALTER TABLE vehicle_request_approvals DROP FOREIGN KEY IF EXISTS `vehicle_request_approvals_current_establishment_id_foreign`');
            DB::statement('ALTER TABLE vehicle_request_approvals DROP FOREIGN KEY IF EXISTS `vehicle_request_approvals_forwarded_by_foreign`');

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