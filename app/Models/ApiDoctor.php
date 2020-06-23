<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiDoctor extends Model
{
    //
    protected $guarded  = ['id','token'];
    protected $table  = "doctor_masters";

    public function department(){
        return $this->belongsTo('App\Models\Department','department_id','id');
    }
    public function DoctorClinic(){
        return $this->hasMany('App\Models\DoctorClinic','id','doctor_id');
    }
}
