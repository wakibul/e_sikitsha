<?php

namespace App\Http\Controllers\Api\Customer\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,DB;
use App\Models\Department;
use App\Models\Autocomplete;
use App\Models\HighestBooking;
class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'region_id'=>'required'
        ]);
        if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }

        $autocomplete = Autocomplete::select('doctor_id')->with(['doctor'=>function($query){
            $query->select('id','name','department_id','email','phone_no','experience','qualification','picture');
        },'doctor.department'=>function($query){
            $query->select('id','name');
        },'DoctorClinic'=>function($query){
            $query->select('id','doctor_id','clinic_id')->groupBy('clinic_id');
        },'DoctorClinic.clinic:id,name,address,latitude,longitude'])->where('region_id',$request->region_id)->groupBy('doctor_id')->paginate(10);
        if(!$autocomplete->isEmpty())
            return response()->json(['success'=>true,'data'=>$autocomplete]);
        else
        return response()->json(['success'=>false]);
    }

    public function special(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'region_id'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }

        $autocomplete = Autocomplete::select('doctor_id')->with(['doctor'=>function($query){
            $query->select('id','name','department_id','email','phone_no','experience','qualification','picture');
        },'doctor.department'=>function($query){
            $query->select('id','name');
        },'DoctorClinic'=>function($query){
            $query->select('id','doctor_id','clinic_id')->groupBy('clinic_id');
        },'DoctorClinic.clinic:id,name,address,latitude,longitude'])->where('region_id',$request->region_id)->where('special_doctor',1)->groupBy('doctor_id')->paginate(10);
        if(!$autocomplete->isEmpty())
            return response()->json(['success'=>true,'data'=>$autocomplete]);
        else
        return response()->json(['success'=>false]);
    }

    public function popular(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'region_id'=>'required'
        ]);
        if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        
        $autocomplete = HighestBooking::select('doctor_id')->with(['doctor'=>function($query){
            $query->select('id','name','department_id','email','phone_no','experience','qualification','picture');
        },'doctor.department'=>function($query){
            $query->select('id','name');
        },'DoctorClinic'=>function($query){
            $query->select('id','doctor_id','clinic_id')->groupBy('clinic_id');
        },'DoctorClinic.clinic:id,name,address,latitude,longitude'])->where('region_id',$request->region_id)->orderBy('total','desc')->take(5)->get();
        if(!$autocomplete->isEmpty())
            return response()->json(['success'=>true,'data'=>$autocomplete]);
        else
        return response()->json(['success'=>false]);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'search'=>'required',
            'region_id'=>'required'
        ]);
        if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $data = [];
        $searchStr = $request->search;
        $departments = Autocomplete::select('department_name','department_id','department_slug')->where([['region_id',$request->region_id],['department_name','like','%'.$searchStr.'%']])->groupBy('department_id')->get();
        foreach($departments as $key1=>$dept){
            array_push($data,["name"=>$dept->department_name,"id"=>$dept->department_id,"type"=>"department","slug"=>$dept->department_slug]);
        }

        $doctors = Autocomplete::select('doctor_name','doctor_id','qualification','doctor_slug')->where([['region_id',$request->region_id],['doctor_name','like','%'.$searchStr.'%']])->groupBy('doctor_id')->get();
        foreach($doctors as $key2=>$doctor){
            array_push($data,["name"=>$doctor->doctor_name." , ".$doctor->qualification,"id"=>$doctor->doctor_id,"type"=>"doctor","slug"=>$doctor->doctor_slug]);
        }

        $clinics = Autocomplete::select('clinic_name','clinic_id','clinic_slug')->where([['region_id',$request->region_id],['clinic_name','like','%'.$searchStr.'%']])->groupBy('clinic_id')->get();
        foreach($clinics as $key2=>$clinic){
            array_push($data,["name"=>$clinic->clinic_name,"id"=>$clinic->clinic_id,"type"=>"clinic","slug"=>$clinic->clinic_slug]);
        }
        if(!empty($data))
            return response()->json(['success'=>true,'data'=>$data]);
        else
            return response()->json(['success'=>false,'data'=>$data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clinic(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'region_id'=>'required',
            'clinic_id'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }

        $autocomplete = Autocomplete::select('doctor_id','clinic_id')->with(['doctor'=>function($query){
            $query->select('id','name','department_id','email','phone_no','experience','qualification','picture');
        },'doctor.department'=>function($query){
            $query->select('id','name');
        },'doctor_clinic'=>function($query){
           $query->select(['clinic[]'=>'id','name','address','latitude','longitude']);
        }])->where([['region_id',$request->region_id],['clinic_id',$request->clinic_id]])->groupBy('doctor_id')->paginate(10);
        if(!$autocomplete->isEmpty())
            return response()->json(['success'=>true,'data'=>$autocomplete]);
        else
        return response()->json(['success'=>false]);
    }

    public function doctor(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'region_id'=>'required',
            'doctor_id'=>'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }

        $autocomplete = Autocomplete::select('doctor_id')->with(['doctor'=>function($query){
            $query->select('id','name','department_id','email','phone_no','experience','qualification','picture');
        },'doctor.department'=>function($query){
            $query->select('id','name');
        },'DoctorClinic'=>function($query){
            $query->select('id','doctor_id','clinic_id')->groupBy('clinic_id');
        },'DoctorClinic.clinic:id,name,address,latitude,longitude'])->where([['region_id',$request->region_id],['doctor_id',$request->doctor_id]])->get();
        //dd($autocomplete);
        if(!$autocomplete->isEmpty())
            return response()->json(['success'=>true,'data'=>$autocomplete]);
        else
        return response()->json(['success'=>false]);
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
}
