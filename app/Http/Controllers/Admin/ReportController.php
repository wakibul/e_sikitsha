<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookingDetail;
use DB, Validator, Redirect, Auth, Crypt, File, Session;
use App\Models\Region;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Specialization;
use App\Helper\Slug;
use App\Models\DoctorMaster;
use App\Models\ScheduleMaster;
use App\Models\DailyAvailable;
use App\Models\Booking;
use App\Models\TempBooking;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $doctors = DoctorMaster::get();
        $appointments = BookingDetail::orderBy('id', 'desc')->where('status','!=',9)->paginate(30);
        return view('admin.report.index', compact('appointments', 'doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $doctors = DoctorMaster::get();
        $validator = Validator::make($request->all(), [
            'date' => 'required'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        if (!empty($request->doctor)) {
            if ($request->doctor == "all") {
                $appointments = BookingDetail::whereDate('booking_date', $request->date)->where('status','!=',9)->orderBy('id', 'desc')->paginate(30);
            } else {
                $appointments = BookingDetail::where('doctor_id', $request->doctor)->whereDate('booking_date', $request->date)->where('status','!=',9)->orderBy('id', 'desc')->paginate(30);
            }
        }

        return view('admin.report.index', compact('appointments', 'doctors'));
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

    public function doctors()
    {
        $doctors = DoctorMaster::withCount(['bookingDetails as booking_count' => function ($query) {
                if (request('from')) {
                    $query->whereBetween('booking_date', [request('from'), request('to')]);
                } else {
                    $query->whereDate('booking_date', date('Y-m-d'));
                }
            }])
            ->withCount(['bookingDetails as visit_count' => function ($query) {
                if (request('from')) {
                    $query->whereBetween('date', [request('from'), request('to')]);
                } else {
                    $query->whereDate('date', date('Y-m-d'));
                }
            }])
            ->where('status', 1)
            ->get();
        return view('admin.report.report-by-date', compact('doctors'));
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
        $id = Crypt::decrypt($id);
        $bookingDetails = BookingDetail::findOrFail($id);
        return view('admin.report.booking-detail', compact('bookingDetails'));
    }

    public function showPatient(Request $request)
    {
        //
        $bookingDetails = BookingDetail::where('doctor_id',request('doctor_id'));
        if (request('from')) {
            $bookingDetails->whereBetween('date', [request('from'), request('to')]);
        } else {
            $bookingDetails->whereDate('date','>=', date('Y-m-d'));
        }
        $bookingDetails = $bookingDetails->where('status','!=',9)->get();
        $doctor = DoctorMaster::where('id',request('doctor_id'))->first();
        return view('admin.report.patient',compact('bookingDetails','doctor'));
        //dd($bookingDetails->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reschedule($id)
    {
        $id = Crypt::decrypt($id);
        $bookingDetails = BookingDetail::with('schedule')->findOrFail($id);
        $future_date = date('Y-m-d').'+ '.intval($bookingDetails->schedule->book_before_days).' days';
        $d = date('Y-m-d',strtotime($future_date));
        $calenderDate = getDatesForCalender($bookingDetails->doctor_id,$bookingDetails->schedule->clinic_id,$d);
        return view('admin.report.reschedule',compact('bookingDetails','calenderDate'));
    }

    public function storeReschedule(Request $request)
    {
        DB::beginTransaction();
        try{
            $bookingDetails = Booking::where('id',$request->booking_id)->update(['date'=>date('Y-m-d',strtotime($request->shift_date)),'slot_id'=>$request->slot_id]);
            $dailyavailable = DailyAvailable::where([['doctor_id',$request->doctor_id],['clinic_id',$request->clinic_id],['schedule_id',$request->schedule_id],['date',date('Y-m-d',strtotime($request->date))]])->first();
            $booked_seat = intval($dailyavailable->booked_seat)-1;
            Session::flash('success', 'Rescheduled Successfully');
            DB::commit();
            return Redirect::back();
        }
        catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attemptedBooking()
    {
        //
        $bookings = TempBooking::with('doctor','clinic_name')->where('status',0)->orderBy('id','desc')->paginate(50);
        return view('admin.report.attempt-booking',compact('bookings'));
    }

    public function postAttemptedBooking(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to'=>'required'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        $bookings = TempBooking::with('doctor','clinic_name')->where('status',0)->whereDate('created_at','>=', $request->from)
        ->whereDate('created_at','<=', $request->to)->orderBy('id','desc')->paginate(50);
        return view('admin.report.attempt-booking',compact('bookings'));
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
        $booking = Booking::find($id)->update(['status'=>9]);
        Session::flash('success', 'Booking Deleted Successfully');
        return redirect()->back();

    }
}
