<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorMaster extends Model
{
    //
	protected $guarded  = ['id','token'];
    protected $with  = ['department','schedule.clinic.region'];

     public static $rules = [
    	'department_id' =>  'required',
    	'name'	=> 	'required',
    	'qualification'  	=>  'required',
    	'fees_online'  	=>  'required',
    	'current_city'  	=>  'required',
        'special_doctor'      =>  'required',
        'picture' => 'nullable|mimes:jpeg,jpg,png'

    ];

    public function getRouteKeyName(){
        return 'slug';
    }

    public function department(){
        return $this->hasOne('App\Models\Department','id','department_id');
    }

    public function available(){
        return $this->hasMany('App\Models\DailyAvailable','doctor_id','id')->where('date','>',date('Y-m-d'));
    }

    public function view_available(){
        return $this->hasMany('App\Models\DailyAvailable','doctor_id','id')->where('date','>=',date('Y-m-d'));
    }

    public function schedule(){
        return $this->hasMany('App\Models\ScheduleMaster','doctor_id','id')->groupBy('clinic_id');
    }

    public function fees(){
        return $this->hasMany('App\Models\DoctorClinic','doctor_id','id');
    }

    public function bookingDetails()
    {
        return $this->hasMany('App\Models\BookingDetail','doctor_id','id');
    }
}
