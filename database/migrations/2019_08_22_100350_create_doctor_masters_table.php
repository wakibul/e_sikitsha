<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('specializations_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone_no');
            $table->integer('experience');
            $table->string('qualification');
            $table->string('licence_no');
            $table->string('location');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_masters');
    }
}
