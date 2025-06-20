<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_declaration_id')->constrained()->onDelete('cascade');
            $table->string('reg_nic');
            $table->string('rank');
            $table->string('driver_name');
            $table->string('unit');
            $table->string('code_no_driver')->nullable();
            $table->string('army_license_no');
            $table->date('license_issued_date');
            $table->date('license_expire_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}