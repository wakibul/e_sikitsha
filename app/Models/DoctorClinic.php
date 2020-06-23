<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorClinic extends Model
{
    //
    protected $guarded = ['id','token'];
    public function clinic(){
        return $this->belongsTo('App\Models\Clinic','clinic_id','id');
    }

    public function doctor(){
        return $this->belongsTo('App\Models\ApiDoctor','doctor_id','id');
    }

}
