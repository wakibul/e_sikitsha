<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //
    protected $guarded = ['id','token'];

    public function clinics(){
    	return $this->hasMany('App\Models\Clinic');
    }
}
