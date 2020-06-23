<?php

namespace App\Http\Controllers\World;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DoctorMaster;
use App\Models\Department;
use App\Models\Region;
use App\Models\Clinic;
use App\Models\ScheduleMaster;
use App\Models\DailyAvailable;
use App\Models\TempBooking;
use App\Models\TempSlotBook;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\RechargeTransaction;
use App\Models\Note;
use App\User;
use Payabbhi\Client as PayabbhiClient;
use DB, Validator, Redirect, Auth, Crypt, Session, Mail;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function about()
    {
        return view('world.about-us');
    }

    public function contact()
    {
        return view('world.contact-us');
    }

    public function service()
    {
        return view('world.service');
    }

    public function refund()
    {
        return view('world.refund-policy');
    }

    public function termCondition()
    {
        return view('world.terms-conditions');
    }

    public function privacyPolicy()
    {
        return view('world.privacy-policy');
    }


    public function feedback(Request $request)
    {
        //return view('world.send-us');
        $to_name = 'Book Ur Doc';
        $to_email = 'wakibulh@gmail.com';
        $email = $request->email;
        $msg = "<table border='0'>";
        $msg .= "<tr><td>Name : ".$request->name." </td></tr>";
        $msg .= "<tr><td>Email : ".$request->email." </td></tr>";
        $msg .= "<tr><td>Feedback : ".$request->complaint." </td></tr>";
        $msg .= "</table>";
        $data = array('name'=>$request->name, "body" =>$msg );
        Mail::send('world.feedback-response', $data, function($message) use ($to_name, $to_email,$email) {
            $message->to($to_email, $to_name)->subject('Feedback');
            $message->from($email,'Feedback');

        });
        return Redirect::back()->with('message','Thank You, for your valuable feedback. We will be get back to you shortly');
    }

    public function departments()
    {
        //
        $departments = Department::orderBy('listorder','asc')->with('doctors.available')->get();
        $regions = Region::get();
        $specializations = Department::orderBy('listorder','asc')->get();
        $special_doctors = DoctorMaster::with('department','available')->where('special_doctor',1)->orderBy('listorder','asc')->get();
        //dd($special_doctors);
        return view('world.department',compact('departments','regions','specializations','special_doctors'));

    }

    public function departmentByID(Request $request)
    {
        //

        $departments = Department::with('doctors.available')->where('slug',$request->slug)->orderBy('listorder','asc')->get();
        $regions = Region::get();
        $specializations = Department::where('slug',$request->slug)->orderBy('listorder','asc')->get();
        //dd($special_doctors);
        return view('world.department',compact('departments','regions','specializations','special_doctors'));

    }

    public function doctor(Request $request)
    {
        //
        $slug = $request->slug;
        $doctor = DoctorMaster::with('department','schedule.clinic.region')->where('slug',$slug)->first();
        $doctor_notes = Note::where('doctor_id',$doctor->id)->first();
        $recomend_doctors = DoctorMaster::with('department','schedule.clinic.region')->where([['department_id',$doctor->department_id],['id','<>',$doctor->id]])->orderBy('listorder','asc')->paginate();
        //dd($doctor);
        return view('world.doctor',compact('doctor','recomend_doctors','doctor_notes'));

    }


    public function book(Request $request, DoctorMaster $doctor, Clinic $clinic)
    {
        // dd('a');
        // //
        // $slug = $request->doctor_slug;
        // $clinic_slug = $request->clinic_slug;
        // $doctor_id = getIdBySlug($slug,"App\Models\DoctorMaster");
        // $clinic_id = getIdBySlug($clinic_slug,"App\Models\Clinic");
        $availableDays = ScheduleMaster::where([['doctor_id',$doctor->id],['clinic_id',$clinic->id],['status',1]])->groupBy('days')->get();
        //dd($availableDays);
        // $doctor = DoctorMaster::with('department','schedule.clinic.region')->where('id',$slug)->first();
        //dd($doctor);
        return view('world.book',compact('doctor','availableDays','clinic'));

    }

    public function ajaxSlot(Request $request)
    {
        $dateExplode = explode("-",$request->date);
        $date = $dateExplode[2].'-'.$dateExplode[1].'-'.$dateExplode[0];
        $availableTime = DailyAvailable::with('schedule')->where([['doctor_id',$request->doctor_id],['date',$date],['status',1],['clinic_id',$request->clinic_id]])->get();
        return response()->json($availableTime);

    }

    public function tempBook(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'slot_id' => 'required',
            'consultation_fees' => 'required|numeric',
            'service_charge' => 'required|numeric',
            'patient_name' => 'required',
            'patient_city' => 'required',
            'phone_no' => 'required',
            'gender' => 'required',
            'age' => 'required|numeric',
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        // Session::flash('error','Due to corona virus pandemic chambers have been cancelled temporarily. Any emergency please contact to your nearest hospital.');
        // return back();
        $transaction_id =  genUniqueID();
        $explodeDate = explode("-",$request->date);
        $date = $explodeDate[2]."-".$explodeDate[1]."-".$explodeDate[0];
        $date = date('Y-m-d',strtotime($date));
        $dailyAvailable = DailyAvailable::where([['doctor_id',$request->doctor_id],['schedule_id',$request->slot_id],['date',$date],['status',1]])->first();
        $seatAvailable = $dailyAvailable->available_seat;
        $tempBook = TempSlotBook::where([['doctor_id',$request->doctor_id],['clinic_id',$request->clinic_id],['schedule_id',$request->slot_id],['date',$date]])->count();

        if($tempBook >= $seatAvailable){
            Session::flash('error','Currently the slot is in process');
            return back();
        }

        $schedule = ScheduleMaster::findOrFail($request->slot_id);
        $future_date = $date.'- '.intval($schedule->book_before_days).' days';
        $chckAppDate = date('Y-m-d',strtotime($future_date));
        //dd($chckAppDate);

        if(date('Y-m-d H:i')>date('Y-m-d H:i',strtotime($chckAppDate." ".$schedule->book_before_time))){
            Session::flash('error','Oops! Booking time is over');
            return back();
        }

        $accessId = env("PAYMENT_ACCESS_ID");
        $secretKey = env("PAYMENT_SECRET_KEY");
        $client = new PayabbhiClient($accessId, $secretKey);


        $data['user_id'] =  0;
        $data['user_type'] =  'guest';
        $data['agent_charge'] =  '0.00';
        $merchantOrderID = uniqid();
        $data['merchant_order_id'] =  $merchantOrderID;

        if($request->fees_mode == 1){
         $data['amount_payable'] = intval($request->consultation_fees)+intval($request->service_charge);
        }
         else{
            $data['amount_payable'] = intval($request->service_charge);
        }
        if(Auth::user())
        {
            if(Auth::user()->type == "franchise")
            {
                $data['user_id'] =  Auth::user()->id;
                $data['user_type'] =  Auth::user()->type;
                $data['agent_charge'] =  $request->agent_charge;
                $data['merchant_order_id'] =  '';

                if($request->fees_mode == 1){
                    $amount_payable = intval($request->consultation_fees)+intval($request->service_charge)+$request->agent_charge;
                    $data['amount_payable'] = $amount_payable;
                }
                 else{
                     $amount_payable = intval($request->service_charge)+$request->agent_charge;
                     $data['amount_payable'] = $amount_payable;
                }

                if(Auth::user()->amount < $amount_payable){
                    Session::flash('error','You have insufficient amount to book an appointment. Kindly contact Administrator');
                    return back();
                }
            }
        }

        if(Auth::guard('admin')->check()==true){
            $data['user_id'] =  Auth::guard('admin')->user()->id;
            $data['user_type'] =  'admin';
            $data['merchant_order_id'] =  '';
        }

$data['transaction_id'] =  $transaction_id;
$data['coupon_id'] =  $request->coupon_id;
$data['date'] =  $date;
$data['doctor_id'] =  $request->doctor_id;
$data['clinic_id'] =  $request->clinic_id;
$data['slot_id'] =  $request->slot_id;
$data['consultation_fees'] =  $request->consultation_fees;
$data['service_charge'] =  $request->service_charge;
$data['patient_name'] =  $request->patient_name;
$data['fees_mode'] =  $request->fees_mode;
$data['patient_city'] =  $request->patient_city;
$data['patient_email'] =  $request->email;
$data['patient_phone'] =  $request->phone_no;
$data['patient_gender'] =  $request->gender;
$data['patient_age'] =  $request->age;
DB::beginTransaction();
try{
    if($insData = TempBooking::updateOrCreate($data)){
     $temp['doctor_id'] =  $request->doctor_id;
     $temp['clinic_id'] =  $request->clinic_id;
     $temp['schedule_id'] =  $request->slot_id;
     $temp['date'] =  $date;
     TempSlotBook::updateOrCreate($temp);
     DB::commit();
     $tempBooking = TempBooking::with('doctor','clinic')->findOrFail($insData->id);
     if((Auth::guard('admin')->check() != true) && (Auth::check() != true)){
     $order = $client->order->create([
        'amount'    =>$tempBooking->amount_payable*100,
        'currency'  =>'INR',
        'merchant_order_id' => $merchantOrderID,
        "notes"     => [
            "merchant_order_id" => (string)$merchantOrderID,
            "payment_processing"    => true
        ]
    ]);

     $payment_data = [
        'access_id'     => $accessId,
        'order_id'      => $order->id,
        'amount'        => $tempBooking->amount_payable*100, //into paisa
        'description'   => env("APP_NAME").': Order #' . $merchantOrderID,
        'prefill'     => [
            'name'      => $tempBooking->patient_name,
            'email'     => $tempBooking->patient_email,
            'contact'   => $tempBooking->patient_phone
        ],
        'notes'       => [
        'merchant_order_id' => (string)$merchantOrderID
        ],
        'theme' => [
            'color' => '#2E86C1'
        ]
    ];
    TempBooking::findOrFail($insData->id)->update(['order_id'=>$order->id]);
}
     return view('world.pay-now',compact('tempBooking','payment_data'));
 }
}
catch (Exception $e)
{

    DB::rollback();
    Session::flash('errors','Something Went Wrong');
    return back();
}
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ticket(Request $request)
    {
        //
        $tempBook = TempBooking::findOrFail($request->temp_booking_id);
        //dd(!Auth::guard('admin')->check());
       if((Auth::guard('admin')->check() != true) && (Auth::check() != true)){
        try{
            $accessId = env("PAYMENT_ACCESS_ID");
            $secretKey = env("PAYMENT_SECRET_KEY");
            $api = new PayabbhiClient($accessId, $secretKey);
            $api->utility->verifyPaymentSignature([
                'payment_id'    => $request->get("payment_id"),
                'order_id'      => $request->get("order_id"),
                'payment_signature' => $request->get("payment_signature"),
            ]);
            $payment = $api->payment->retrieve($request->get("payment_id"));
            // verification passed
            //dd($payment);
            } catch (\Payabbhi\Error\SignatureVerification $e) {
            // verification failed
            Session::flash('errors','Payment Details fetching error. Wait sometimes or contact to helpline no.');
            return view("world.payment-error");
            }
        }
        DB::beginTransaction();
        try{
            $data['temp_booking_id'] =  $tempBook->id;
            $data['transaction_id'] =  $tempBook->transaction_id;
            $data['date'] =  $tempBook->date;
            $data['doctor_id'] =  $tempBook->doctor_id;
            $data['clinic_id'] =  $tempBook->clinic_id;
            $data['slot_id'] =  $tempBook->slot_id;
            $data['consultation_fees'] =  $tempBook->consultation_fees;
            $data['service_charge'] =  $tempBook->service_charge;
            $data['agent_charge'] =  $tempBook->agent_charge;
            $data['amount_payable'] =  $tempBook->amount_payable;
            $data['fees_mode'] =  $tempBook->fees_mode;
            $data['patient_name'] =  $tempBook->patient_name;
            $data['patient_city'] =  $tempBook->patient_city;
            $data['patient_email'] =  $tempBook->patient_email;
            $data['patient_phone'] =  $tempBook->patient_phone;
            $data['patient_gender'] =  $tempBook->patient_gender;
            $data['patient_age'] =  $tempBook->patient_age;
            $data['status'] =  1;
            $data['user_id'] =   $tempBook->user_id;
            $data['user_type'] = $tempBook->user_type;
            if((Auth::guard('admin')->check() != true) && (Auth::check() != true)){
            $data['order_id'] = $payment->order_id;
            $data['payment_amount'] = ($payment->amount)/100;
            $data['payment_status'] = $payment->status;
            }

            if($booking = Booking::firstOrCreate($data)){
                //dd($booking);
                if ($booking->wasRecentlyCreated) {
                   TempBooking::findOrFail($request->temp_booking_id)->update(['status'=>1,'payment_done'=>1,'online_payment_successes_id'=>$booking->id]);
                   $dailyAvaliable = DailyAvailable::where([['doctor_id',$booking->doctor_id],['schedule_id',$booking->slot_id],['date',$booking->date]])->first();
                   $booked_seat = intval($dailyAvaliable->booked_seat)+intval(1);
                 //dd($dailyAvaliable);
                   if($dailyAvaliable->available_seat > $dailyAvaliable->booked_seat){
                    DailyAvailable::where([['doctor_id',$booking->doctor_id],['schedule_id',$booking->slot_id],['date',$booking->date]])->update(['booked_seat'=>$booked_seat]);
                }

                $daily = DailyAvailable::where([['doctor_id',$booking->doctor_id],['schedule_id',$booking->slot_id],['date',$booking->date]])->first();

                if($daily->available_seat == $daily->booked_seat){
                    DailyAvailable::where([['doctor_id',$booking->doctor_id],['schedule_id',$booking->slot_id],['date',$booking->date]])->update(['status'=>2]);
                }
                if(Auth::user()){
                    if(Auth::user()->type == "franchise"){
                        $recharge['franchise_id'] = Auth::user()->id;
                        $recharge['amount'] = $booking->amount_payable;
                        $recharge['type'] = 'd';
                        if(RechargeTransaction::create($recharge)){
                            $updated_balance = intval(Auth::user()->amount)-intval($booking->amount_payable);
                            User::where('id',Auth::user()->id)->update(['amount'=>$updated_balance]);
                        }
                    }
                }
                 //::
                Booking::where('id',$booking->id)->update(['sl_no_ticket'=>$booked_seat]);
                $doctor = DoctorMaster::findOrFail($booking->doctor_id);
                $clinic = Clinic::with('region')->findOrFail($booking->clinic_id);
                $schedule = ScheduleMaster::findOrFail($booking->slot_id);
                DB::commit();
                $message = "";
                $bookingDetails = BookingDetail::where('id',$booking->id)->first();
                $message .= "www.bookurdoc.com\n";
                $message .= $bookingDetails->transaction_id."\n";
                if($bookingDetails->fees_mode == 1){
                    $message .= "Recieved Rs ".$bookingDetails->amount_payable." from ".$bookingDetails->patient_name.". Ticket booked for ".$bookingDetails->doctor_name." for ".date('d-M-Y',strtotime($bookingDetails->date))." at ".$bookingDetails->slot." in ".$bookingDetails->clinic_name. $bookingDetails->clinic_address. ". Chamber will provide serial no. For any query call 8812907328/8876657929.\n";
                }
                else{
                    $message .= "Recieved Rs ".$bookingDetails->amount_payable." from ".$bookingDetails->patient_name." Ticket booked for ".$bookingDetails->doctor_name." for ".date('d-M-Y',strtotime($bookingDetails->date))." at ".$bookingDetails->slot ." in ".$bookingDetails->clinic_name. $bookingDetails->clinic_address. ". Please pay consultation fee of Rs ".$bookingDetails->amount_payable." to the Doctor. Chamber will provide serial no. For any query call 8812907328/8876657929.\n";
                }
                $message .= "GET WELL SOON";
                sendSMS($booking->patient_phone,$message);
            }
            else{
                $booking = Booking::findOrFail($booking->id);
                $doctor = DoctorMaster::findOrFail($booking->doctor_id);
                $clinic = Clinic::with('region')->findOrFail($booking->clinic_id);
                $schedule = ScheduleMaster::findOrFail($booking->slot_id);

            }
            return view('world.ticket',compact('booking','doctor','clinic','schedule'));
        }
    }
    catch (Exception $e){
        DB::rollback();
        Session::flash('errors','Something Went Wrong');
        return back();
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
