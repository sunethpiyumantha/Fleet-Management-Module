<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   class CreateWorkshopsTable extends Migration
   {
       public function up()
       {
           Schema::create('workshops', function (Blueprint $table) {
               $table->id();
               $table->string('serial_number')->nullable()->unique();
               $table->string('workshop_type');
               $table->timestamps();
               $table->softDeletes();
           });
       }

       public function down()
       {
           Schema::dropIfExists('workshops');
       }
   }