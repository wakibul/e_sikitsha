<?php

namespace App\Http\Controllers\Api\Customer\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\ScheduleMaster;
use App\Models\AvailableDate;
use App\Models\DoctorClinic;
use App\Models\DailyAvailable;
use Dotenv\Validator as DotenvValidator;

class ScheduleController extends Controller
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
                'doctor_id'=>'required'
            ]);
        if ($validator->fails()) {
                return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
       $clinics = ScheduleMaster::select('id','doctor_id','clinic_id')->with('clinic')->where('doctor_id',$request->doctor_id)->groupBy('clinic_id')->get();
      if(!$clinics->isEmpty())
        return response()->json(['success'=>true,'clinics'=>$clinics]);
       else
       return response()->json(['success'=>false]);

    }

    public function schedule(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
                'doctor_id'=>'required',
                'clinic_id'=>'required'
            ]);
        if ($validator->fails()) {
                return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
       $doctorClinic =  DoctorClinic::select('doctor_id','clinic_id','doctor_fees','booking_charge')
       ->with('doctor:id,fees_online')
       ->where([['doctor_id',$request->doctor_id],['clinic_id',$request->clinic_id]])->groupBy('clinic_id')->get();
       $schedules = ScheduleMaster::select('id','slot')->where([['doctor_id',$request->doctor_id],['clinic_id',$request->clinic_id]])->groupBy('slot')->get();
       $days = ScheduleMaster::select('days')->where([['doctor_id',$request->doctor_id],['clinic_id',$request->clinic_id]])->groupBy('days')->get();
       $availableDates = AvailableDate::select('date')->where([['doctor_id',$request->doctor_id],['clinic_id',$request->clinic_id],['date','>=',date('Y-m-d')],['status',1]])->groupBy('date')->get();
       if(!$doctorClinic->isEmpty())
            return response()->json(['success'=>true,'fees'=>$doctorClinic,'schedule'=>$schedules,'days'=>$days,'available_dates'=>$availableDates]);
       else
            return response()->json(['success'=>false]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function slot(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'doctor_id' => 'required|numeric',
            'clinic_id' => 'required|numeric',
            'date' => 'required'
        ]);
        if($validator->fails())
            return response()->json(['success'=>false,'errors'=>$validator->errors()]);

        $availableTime = DailyAvailable::select('id','schedule_id')->with('schedule:id,slot')->where([['doctor_id',$request->doctor_id],['date',date('Y-m-d',strtotime($request->date))],['status',1],['clinic_id',$request->clinic_id]])->get();
        if(!$availableTime->isEmpty())
            return response()->json(['success'=>true,'available'=>$availableTime]);
        else
        return response()->json(['success'=>false]);
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
