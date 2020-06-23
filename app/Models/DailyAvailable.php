<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyAvailable extends Model
{
    //
    protected $guarded  = ['id','token'];
    public function schedule(){
    	return $this->belongsTo('App\Models\ScheduleMaster','schedule_id','id');
    }

    public function clinic(){
    	return $this->belongsTo('App\Models\Clinic','clinic_id','id');
    }
}
