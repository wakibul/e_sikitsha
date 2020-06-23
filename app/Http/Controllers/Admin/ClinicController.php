<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator, Redirect, Auth, Crypt;
use App\Models\Region;
use App\Models\Clinic;
use App\Helper\Slug;
class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clinics = Clinic::with('region')->where('status',1)->paginate();
        //dd($clinics);
        return view('admin.clinic.index',compact('clinics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cities = Region::get();
        return view('admin.clinic.create',compact('cities'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'region_id' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'mobile_no' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'clinic_type' => 'required'

        ]);
        $data['region_id'] = $request->region_id;
        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['mobile_no'] = $request->phone;
        $data['latitude'] = $request->latitude;
        $data['longitude'] = $request->longitude;
        $data['clinic_type'] = $request->clinic_type;
        $slug = new Slug();
        $data['slug'] = $slug->createSlug("App\Models\Clinic",$request->name);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        if(Clinic::create($data)){
            return Redirect::route('admin.clinic.create')->with('success','Clinic added successfully');
        }
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
        $id = Crypt::decrypt($id);
        $clinic = Clinic::findOrFail($id);
        $cities = Region::get();
        return view('admin.clinic.edit',compact('clinic','cities'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'region_id' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'clinic_type' => 'required'

        ]);
        $id = Crypt::decrypt($id);
        $data['region_id'] = $request->region_id;
        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['latitude'] = $request->latitude;
        $data['longitude'] = $request->longitude;
        $data['clinic_type'] = $request->clinic_type;
        $data['mobile_no'] = $request->mobile_no;
        $slug = new Slug();
        $data['slug'] = $slug->createSlug("App\Models\Clinic",$request->name);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        if(Clinic::findOrFail($id)->update($data)){
            return Redirect::back()->with('success','Clinic updated successfully');
        }

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
        $id = Crypt::decrypt($id);
        Clinic::findOrFail($id)->delete();
        return Redirect::back()->with('success','Deleted');
    }
}
