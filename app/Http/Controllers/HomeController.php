<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator, Redirect, Auth, Crypt;
use App\Models\Department;
use App\Helper\Slug;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$departments = Department::where('status',1)->take(8)->get();
        //return view('home',compact('departments'));
    }
}
