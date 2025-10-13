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
            // Ensure column types match (bigint unsigned for establishments.e_id; skip if already correct)
            if (Schema::hasColumn('vehicle_request_approvals', 'initiate_establishment_id') && Schema::getColumnType('vehicle_request_approvals', 'initiate_establishment_id') !== 'bigint unsigned') {
                $table->unsignedBigInteger('initiate_establishment_id')->nullable()->change();
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'current_establishment_id') && Schema::getColumnType('vehicle_request_approvals', 'current_establishment_id') !== 'bigint unsigned') {
                $table->unsignedBigInteger('current_establishment_id')->nullable()->change();
            }

            // Get current table definition to check for existing constraints
            $tableDefinition = DB::select("SHOW CREATE TABLE vehicle_request_approvals")[0]->{'Create Table'};

            // Add FK for initiate_establishment_id -> establishments.e_id (bigint unsigned) - standardized name
            if (Schema::hasColumn('vehicle_request_approvals', 'initiate_establishment_id') && !str_contains($tableDefinition, 'initiate_establishment_id_foreign')) {
                $table->foreign('initiate_establishment_id', 'initiate_establishment_id_foreign')
                      ->references('e_id')->on('establishments')
                      ->onDelete('cascade');
            }

            // Add FK for current_establishment_id -> establishments.e_id
            if (Schema::hasColumn('vehicle_request_approvals', 'current_establishment_id') && !str_contains($tableDefinition, 'current_establishment_id_foreign')) {
                $table->foreign('current_establishment_id', 'current_establishment_id_foreign')
                      ->references('e_id')->on('establishments')
                      ->onDelete('cascade');
            }

            // Add FK for user_id -> users.id (assuming bigint unsigned) - if column exists
            if (Schema::hasColumn('vehicle_request_approvals', 'user_id') && !str_contains($tableDefinition, 'vehicle_request_approvals_user_id_foreign')) {
                $table->foreign('user_id', 'vehicle_request_approvals_user_id_foreign')
                      ->references('id')->on('users')
                      ->onDelete('cascade');
            }

            // Add FK for approved_by -> users.id
            if (Schema::hasColumn('vehicle_request_approvals', 'approved_by') && !str_contains($tableDefinition, 'vehicle_request_approvals_approved_by_foreign')) {
                $table->foreign('approved_by', 'vehicle_request_approvals_approved_by_foreign')
                      ->references('id')->on('users')
                      ->onDelete('set null');
            }

            // Add for forwarded_by if exists
            if (Schema::hasColumn('vehicle_request_approvals', 'forwarded_by')) {
                if (!str_contains($tableDefinition, 'vehicle_request_approvals_forwarded_by_foreign')) {
                    $table->foreign('forwarded_by', 'vehicle_request_approvals_forwarded_by_foreign')
                          ->references('id')->on('users')
                          ->onDelete('set null');
                }
            }

            // Add for initiated_by if exists (user ID)
            if (Schema::hasColumn('vehicle_request_approvals', 'initiated_by')) {
                if (!str_contains($tableDefinition, 'vehicle_request_approvals_initiated_by_foreign')) {
                    $table->foreign('initiated_by', 'vehicle_request_approvals_initiated_by_foreign')
                          ->references('id')->on('users')
                          ->onDelete('cascade');
                }
            }

            // Add for current_user_id if exists (user ID)
            if (Schema::hasColumn('vehicle_request_approvals', 'current_user_id')) {
                if (!str_contains($tableDefinition, 'vehicle_request_approvals_current_user_id_foreign')) {
                    $table->foreign('current_user_id', 'vehicle_request_approvals_current_user_id_foreign')
                          ->references('id')->on('users')
                          ->onDelete('cascade');
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_request_approvals', function (Blueprint $table) {
            // Drop foreign keys only if they exist
            $possibleFks = ['initiate_establishment_id', 'current_establishment_id', 'user_id', 'approved_by'];
            foreach ($possibleFks as $fk) {
                if (Schema::hasColumn('vehicle_request_approvals', $fk)) {
                    $table->dropForeign([$fk]);
                }
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'forwarded_by')) {
                $table->dropForeign(['forwarded_by']);
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'initiated_by')) {
                $table->dropForeign(['initiated_by']);
            }
            if (Schema::hasColumn('vehicle_request_approvals', 'current_user_id')) {
                $table->dropForeign(['current_user_id']);
            }
        });
    }
};