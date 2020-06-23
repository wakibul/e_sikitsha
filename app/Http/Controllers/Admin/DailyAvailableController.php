<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator, Redirect, Auth, Crypt;
use App\Models\Region;
use App\Models\Clinic;
use App\Models\Departments;
use App\Models\Specialization;
use App\Helper\Slug;
use App\Models\DoctorMaster;
use App\Models\ScheduleMaster;
use App\Models\DailyAvailable;
class DailyAvailableController extends Controller
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

        $maxDate = DailyAvailable::max('date');
        if($maxDate == null){
             $maxDate = date('Y-m-d');
        }        //dd($maxDate);
        $availableDate =  date('Y-m-d', strtotime($maxDate . ' +1 day'));
        $doctors = DoctorMaster::where('status',1)->get();
        foreach($doctors as $key=>$doctor){
           $schedules =  ScheduleMaster::where('doctor_id',$doctor->id)->get();
           foreach ($schedules as $key => $schedule) {

                $daily = DailyAvailable::where([['doctor_id',$doctor->id],['schedule_id',$schedule->id],['date',$availableDate]])->first();
                if(empty($daily)){
                    DB::beginTransaction();
                    try {
                          $data['doctor_id']  = $doctor->id;
                          $data['schedule_id']  = $schedule->id;
                          $data['date']  = $availableDate;
                          $data['available_seat']  = $schedule->max_booking;
                          if(DailyAvailable::create($data))
                          {
                            DB::commit();
                          }
                          else
                            return response()->json(['success'=>false,'message'=>'Could not added !!!!!!!!!!!']);

                      }
                        catch (Exception $e) 
                        {
                            DB::rollback();
                            dd($e);
                            Session::flash('error','Something Went Wrong');
                            return back();
                        }

                }
                else{

                    return response()->json(['success'=>false,'message'=>'Date is already added']);
                }


           }

        }
        return response()->json(['success'=>true,'message'=>'A new entry added successfully']);


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
