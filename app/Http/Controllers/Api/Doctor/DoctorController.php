<?php

namespace App\Http\Controllers\Api\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DoctorMaster;
use App\Models\Clinic;
use DB, Validator, Redirect, Auth, Crypt, File;
use App\Helper\Slug;
use App\Models\ScheduleMaster;
use App\Models\Region;
use App\Models\DoctorClinic;
use PhpParser\Node\Stmt\Catch_;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateGeneralProfile(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'gender'=> 'required',
            'experience'=> 'required',
            'current_city'=> 'required',
            'qualification'=> 'required',
            'fees_online'=> 'required',
            'dr_available_days'=> 'required',
            'special_doctor'=> 'required',
            'picture'=> 'nullable|sometimes|mimes:jpeg,jpg,png,gif|required|max:50000',
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $doctor['email'] = $request->email;
        $doctor['name'] = $request->name;
        $doctor['gender'] = $request->gender;
        $doctor['experience'] = $request->experience;
        $doctor['current_city'] = $request->current_city;
        $doctor['qualification'] = $request->qualification;
        $doctor['fees_online'] = $request->fees_online;
        $doctor['dr_available_days'] = $request->dr_available_days;
        $doctor['special_doctor'] = $request->special_doctor;
        $slug = new Slug();
        $doctor['slug'] = $slug->createSlug("App\Models\DoctorMaster", $request->name);
        if ($request->hasFile('picture')) {
            try {
                $path = public_path() . '/images/profile/';
                $imageName = date('dmyhis') . 'profile.' . $request->file('picture')->getClientOriginalExtension();
                //dd($imageName);
                $request->file('picture')->move($path, $imageName);
                $doctor['picture'] = url('/public') . '/images/profile/' . $imageName;
            } catch (\Exception $e) {
                //dd($e);
                return response()->json(['success'=>false,'error'=>$e->getMessage()]);
            }
        }
        try{
                DoctorMaster::findOrFail(auth('doctor')->id())->update($doctor);
                $doctorInfo = DoctorMaster::findOrFail(auth('doctor')->user()->id);
                return response()->json(['success'=>true,'doctor'=>$doctorInfo]);
            }
            catch (\Exception $e) {
                //dd($e);
                return response()->json(['success'=>false,'error'=>$e->getMessage()]);
            }

    }



    public function addSchedule(Request $request)
    {
        //dd($request->Schedule);
        $validator = Validator::make($request->all(), [
            'Schedule'=> 'required',
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $allSchedule = json_decode($request->Schedule,true);
        DB::beginTransaction();
        try
        {
            foreach ($allSchedule as $key => $schedule){
                foreach ($schedule as $key => $val){
                    if (!empty($val['day'])) {
                            $schedules['doctor_id'] = auth('doctor')->user()->id;
                            $schedules['starttime'] = $val['start_time'];
                            $schedules['endtime'] = $val['end_time'];
                            $schedules['clinic_id'] = $val['clinic'];;
                            $schedules['days'] =$val['day'];
                            $schedules['slot'] = date('h:i A', strtotime($val['start_time'])) . "-" . date('h:i A', strtotime($val['end_time']));
                            $schedules['max_booking'] = $val['max_book'];
                            $schedules['book_before_days'] = $val['before_day'];
                            $schedules['book_before_time'] = $val['before_time'];
                            ScheduleMaster::create($schedules);
                        }
                }
            }
        }
        catch (Exception $e) {
                    DB::rollback();
                    return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
        DB::commit();
        return response()->json(['success'=>true,'message'=>'Schedule added successfully']);


    }

    public function viewSchedule()
    {
       //dd($doctor);
       $schedule = ScheduleMaster::select('id','doctor_id','clinic_id','slot','max_booking')->with('clinic')->where('doctor_id',auth('doctor')->id())->orderBy('days','desc')->get();
       return response()->json(['success'=>true,'schedule'=>$schedule]);

    }

    public function getPriceSchedule()
    {
        $schedule = ScheduleMaster::select('id','doctor_id','clinic_id','slot','max_booking')->with('clinic')->where('doctor_id',auth('doctor')->id())->orderBy('days','desc')->groupBy('clinic_id')->get();
        return response()->json(['success'=>true,'schedule'=>$schedule]);
    }

    public function addPrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prices'=> 'required',
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $fees = json_decode($request->prices,true);
        DB::beginTransaction();
        try
        {
            foreach($fees as $key=>$fee){
                foreach($fee as $key=>$val){
                    if(!empty($val['clinic_id'])){
                        $price['doctor_id'] = $val['doctor_id'];
                        $price['clinic_id'] = $val['clinic_id'];
                        $price['doctor_fees'] = $val['doctor_fees'];
                        $price['booking_charge'] = $val['booking_charge'];
                        $price['agent_charge'] = $val['agent_charge'];
                        DoctorClinic::create($price);
                    }
                }
            }
        }
        catch (Exception $e) {
            DB::rollback();
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
        DB::commit();
        return response()->json(['success'=>true,'message'=>'Prices added successfully']);

    }

    public function viewPrice()
    {

        $doctor_clinic = DoctorClinic::with('clinic')->where('doctor_id',auth('doctor')->id())->get();

        if(!$doctor_clinic->isEmpty()){
            
            return response()->json(['success'=>true,'price'=>$doctor_clinic]);
        }
        else{
            return response()->json(['success'=>false,'message'=>"Please add your schedule first"]);
        }

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

    public function getRegion(Request $request)
    {
        //
        $regions = Region::with('clinics')->get();
        return response()->json(['success'=>true,'region'=>$regions]);
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
}
