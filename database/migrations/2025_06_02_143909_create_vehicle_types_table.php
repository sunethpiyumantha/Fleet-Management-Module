<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('vehicle_types', function (Blueprint $table) {
        $table->string('vehicle_type')->unique()->after('id');
    });
}

public function down()
{
    Schema::table('vehicle_types', function (Blueprint $table) {
        $table->dropColumn('vehicle_type');
    });
}
};
