<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator, Redirect, Auth, Crypt;
use App\Models\Region;
use App\Models\Clinic;
use App\Helper\Slug;
class CityController extends Controller
{
    //
    public function index()
    {
        $cities = Region::paginate(30);
        return view('admin.city.index',compact('cities'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        $data['name'] = $request->name;
        $slug = new Slug();
        $data['slug'] = $slug->createSlug("App\Models\Region",$request->name);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        if(Region::create($data)){
            return Redirect::route('admin.city.index')->with('success','City added successfully');
        }
       
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $city = Region::findOrFail($id);
        return view('admin.city.edit',compact('city'));
    }

    public function update(Request $request,$id)
    {
        $id = Crypt::decrypt($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        $name = $request->name;
        if(Region::findOrFail($id)->update(['name'=>$name])){
            return Redirect::route('admin.city.index')->with('success','City Updated');
        }
       
    }


    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $city = Region::findOrFail($id)->delete();
        $cities = Region::paginate(30);
        return view('admin.city.index',compact('cities'));
    }

    public function  ajaxClinic(Request $request){

        $clinic = Clinic::where('region_id',$request->id)->get();
        return response()->json($clinic);

    }
}