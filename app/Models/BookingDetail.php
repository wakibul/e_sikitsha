<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    //
    public function doctor(){
    	return $this->belongsTo('App\Models\DoctorMaster','doctor_id','id');
    }

    public function schedule(){
    	return $this->belongsTo('App\Models\ScheduleMaster','slot_id','id');
    }
}
