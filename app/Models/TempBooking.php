<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempBooking extends Model
{
    //
    protected $guarded  = ['id','token'];
    public function doctor(){
    	return $this->belongsTo('App\Models\DoctorMaster','doctor_id','id');
    }

    public function clinic(){
        return $this->hasMany('App\Models\Clinic','id','clinic_id');
    }

    public function schedule(){
        return $this->hasOne('App\Models\ScheduleMaster','id','slot_id');
    }

    public function clinic_name(){
        return $this->belongsTo('App\Models\Clinic','clinic_id','id');
    }
}
