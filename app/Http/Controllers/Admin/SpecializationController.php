<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator, Redirect, Auth, Crypt;
use App\Models\Specialization;
use App\Helper\Slug;
class SpecializationController extends Controller
{
    public function index()
    {
        $specializations = Specialization::paginate(30);
        return view('admin.specialization.index',compact('specializations'));
    }
}
