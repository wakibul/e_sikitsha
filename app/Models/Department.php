<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    protected $fillable = ['name','picture','slug','created_at'];

    public function doctors(){
        return $this->hasMany('App\Models\DoctorMaster','department_id')->orderBy('listorder','asc');
    }
}
