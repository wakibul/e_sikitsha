<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForignKeyToScheduleMasters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedule_masters', function (Blueprint $table) {
            //
            $table->integer('doctor_id')->unsigned()->change();
            $table->integer('clinic_id')->unsigned()->change();
            $table->foreign('doctor_id')->references('id')->on('doctor_masters')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule_masters', function (Blueprint $table) {
            //
            $table->dropForeign('doctor_id');
            $table->dropForeign('clinic_id');
        });
    }
}
