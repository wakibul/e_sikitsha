<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id');
            $table->string('coupon_id');
            $table->date('date');
            $table->string('doctor_id');
            $table->string('clinic_id');
            $table->string('slot');
            $table->double('consultation_fees',10,2);
            $table->double('service_charge',10,2);
            $table->double('agent_charge',10,2);
            $table->string('patient_name');
            $table->string('patient_city');
            $table->string('patient_email');
            $table->string('patient_phone');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('temp_bookings');
    }
}
