<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleMaster extends Model
{
    //
    protected $guarded  = ['id','token'];
    public function clinic(){
    	return $this->belongsTo('App\Models\Clinic','clinic_id');
    }
}
