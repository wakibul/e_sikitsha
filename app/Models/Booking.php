<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $guarded  = ['id','token'];
    public function doctor(){
        return $this->belongsTo('App\Models\DoctorMaster','doctor_id');
    }

    public function clinic(){
        return $this->belongsTo('App\Models\Clinic','clinic_id');
    }

    public function slot(){
        return $this->belongsTo('App\Models\ScheduleMaster','slot_id');
    }
}
