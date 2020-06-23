<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    //
    protected $guarded = ['id','token'];

    public function getRouteKeyName(){
        return 'slug';
    }
    
    public function region(){
    	return $this->belongsTo('App\Models\Region','region_id','id');
    }

    
}
