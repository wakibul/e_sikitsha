<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForignKeyToDailyAvailables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_availables', function (Blueprint $table) {
            //
            $table->integer('doctor_id')->unsigned()->change();
            $table->integer('clinic_id')->unsigned()->change();
            $table->integer('schedule_id')->unsigned()->change();
            $table->foreign('doctor_id')->references('id')->on('doctor_masters')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('schedule_masters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_availables', function (Blueprint $table) {
            //
            $table->dropForeign('doctor_id');
            $table->dropForeign('clinic_id');
            $table->dropForeign('schedule_id');
        });
    }
}
