<?php

namespace App\Http\Controllers\Cron;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator, Redirect, Auth, Crypt, File, Session;
use App\Models\Region;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Specialization;
use App\Helper\Slug;
use App\Models\Booking;
use App\Models\DoctorMaster;
use App\Models\ScheduleMaster;
use App\Models\DailyAvailable;
use App\Models\DoctorClinic;
use App\Models\BookingDetail;
class CronController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd($request->doctor_id);
        $doctorMaster = DoctorMaster::where('status',1)->get();
        foreach($doctorMaster as $key=>$doctor){
        $doctor_id = $doctor->id;
        $dr_available_days = ($doctor->dr_available_days)*7;
        $date = date('Y-m-d');
        $max_date = date('Y-m-d', strtotime($date . '+ ' . $dr_available_days . ' days'));
        //$daily_avalables = DailyAvailable::where([['doctor_id', $doctor_id], ['status', 1]])->get();
        $daily_avalables = DailyAvailable::where('doctor_id', $doctor_id)->get();
        DB::beginTransaction();
         try {
            $all_days = getDatesFromRange($date, $max_date);
            foreach ($all_days as $key => $day) {
                $schedules =  ScheduleMaster::where('doctor_id', $doctor_id)->get();
                foreach ($schedules as $key => $schedule) {
                    $d = date('l', strtotime($day));
                    if ($d == $schedule->days) {
                        $dailyCount = DailyAvailable::where('date','=',date('Y-m-d', strtotime($day)))->where('doctor_id',$doctor_id)->where('schedule_id',$schedule->id)->count();
                        //var_dump($dailyCount);
                        if($dailyCount == 0){
                            $data['doctor_id']  = $doctor_id;
                            $data['schedule_id']  = $schedule->id;
                            $data['clinic_id']  = $schedule->clinic_id;
                            $data['sms_time']  =  $schedule->sms_time;
                            $data['date']  = date('Y-m-d', strtotime($day));
                            $data['available_seat']  = $schedule->max_booking;
                            DailyAvailable::create($data);
                        }

                    }
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', 'Something Went Wrong');
        }
        DB::commit();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autoSms()
    {
        //
        $doctors = DoctorMaster::where('status',1)->get();
        foreach($doctors as $key=>$doctor){
            foreach($doctor->schedule as $value){
                $future_date = date('Y-m-d').'+ '.intval($value->book_before_days).' days';
                $chckAppDate = date('Y-m-d',strtotime($future_date));
                //dd($chckAppDate);
                $daily_avalables = DailyAvailable::with('clinic')->where([['doctor_id',$doctor->id],['date',$chckAppDate],['sms_status',0],['status',1]])->get();
                foreach($daily_avalables as $key=>$daily){
                $bookings = BookingDetail::where([['doctor_id',$daily->doctor_id],['clinic_id',$daily->clinic_id],['slot_id',$daily->schedule_id],['date',$daily->date],['status',1]])->get();
                $message = "";
                $totalBooking = count($bookings);
                foreach($bookings as $key=>$booking){
                    $message .= "www.bookurdoc.com\n";
                    $message .= "List of ". $totalBooking ." patients for ".$booking->doctor_name." on ". date('d-m-Y',strtotime($booking->date))." ".$booking->slot."\n";
                    $message .= ($key+1)."). PATIENT NAME - ".$booking->patient_name." \n";
                    $message .= "Please provide serial number to patient. Call us at 8812907328/8876657929 for any query";

                    if($daily->sms_time == date('H:i')){
                        sendSMS($daily->clinic->mobile_no,$message);
                        DailyAvailable::findOrFail($daily->id)->update(['sms_status'=>1]);
                        }
                    }
                }
            }
        }
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
