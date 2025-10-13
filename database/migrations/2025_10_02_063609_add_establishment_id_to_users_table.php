<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('establishment_id')->nullable()->index()->after('role_id'); // Use unsignedBigInteger to match bigint unsigned in establishments.e_id
            $table->foreign('establishment_id')->references('e_id')->on('establishments')->onDelete('set null'); // Set to null on delete for flexibility
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['establishment_id']);
            $table->dropColumn('establishment_id');
        });
    }
};