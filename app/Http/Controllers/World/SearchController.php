<?php

namespace App\Http\Controllers\World;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator, Redirect, Auth, Crypt;
use App\Models\Autocomplete;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function autocomplete(Request $request)
    {
        //
        $data = [];
        $searchStr = $request->search;
        $departments = Autocomplete::select('department_name','department_id','department_slug')->where([['region_id',$request->region],['department_name','like','%'.$searchStr.'%']])->groupBy('department_id')->get();
        foreach($departments as $key1=>$dept){
            array_push($data,["name"=>$dept->department_name,"id"=>$dept->department_id,"type"=>"department","slug"=>$dept->department_slug]);
        }

        $doctors = Autocomplete::select('doctor_name','doctor_id','qualification','doctor_slug')->where([['region_id',$request->region],['doctor_name','like','%'.$searchStr.'%']])->groupBy('doctor_id')->get();
        foreach($doctors as $key2=>$doctor){
            array_push($data,["name"=>$doctor->doctor_name." , ".$doctor->qualification,"id"=>$doctor->doctor_id,"type"=>"doctor","slug"=>$doctor->doctor_slug]);
        }

        $clinics = Autocomplete::select('clinic_name','clinic_id','clinic_slug')->where([['region_id',$request->region],['clinic_name','like','%'.$searchStr.'%']])->groupBy('clinic_id')->get();
        foreach($clinics as $key2=>$clinic){
            array_push($data,["name"=>$clinic->clinic_name,"id"=>$clinic->clinic_id,"type"=>"clinic","slug"=>$clinic->clinic_slug]);
        }
        return response()->json($data);
    }


    public function location()
    {

        $region = Region::select('name','slug')->get();
        return response()->json($region);
    }

    public function autoregion()
    {

        $location = Region::select('name')->get();
        return response()->json($location);
    }
}
