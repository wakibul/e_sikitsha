<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TempBooking;
use App\Models\ScheduleMaster;
use App\Models\DailyAvailable;
use App\Models\TempSlotBook;
use App\Models\Booking;
use App\Models\DoctorMaster;
use App\Models\Clinic;
use App\Models\BookingDetail;
use App\Models\Department;
use Validator,DB;
use Payabbhi\Client as PayabbhiClient;
class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            'fees_mode' => 'required',
            'doctor_id' => 'required',
            'clinic_id' => 'required'
        ]);
        if ($validator->fails())
        return response()->json(['success'=>false,'error'=>$validator->errors()]);

        $transaction_id =  genUniqueID();
        $explodeDate = explode("-",$request->date);
        $date = $explodeDate[2]."-".$explodeDate[1]."-".$explodeDate[0];
        $date = date('Y-m-d',strtotime($date));
        $dailyAvailable = DailyAvailable::where([['doctor_id',$request->doctor_id],['schedule_id',$request->slot_id],['date',$date],['status',1]])->first();
        $seatAvailable = $dailyAvailable->available_seat;
        $tempBook = TempSlotBook::where([['doctor_id',$request->doctor_id],['clinic_id',$request->clinic_id],['schedule_id',$request->slot_id],['date',$date]])->count();

        if($tempBook >= $seatAvailable){
            return response()->json(['success'=>false,'error'=>['message'=>'Currently the slot is in process']]);
        }

        $schedule = ScheduleMaster::findOrFail($request->slot_id);
        $future_date = $date.'- '.intval($schedule->book_before_days).' days';
        $chckAppDate = date('Y-m-d',strtotime($future_date));
        //dd($chckAppDate);

        if(date('Y-m-d H:i')>date('Y-m-d H:i',strtotime($chckAppDate." ".$schedule->book_before_time))){
            return response()->json(['success'=>false,'error'=>['message'=>'Oops! Booking time is over']]);
        }

        // $accessId = env("PAYMENT_ACCESS_ID");
        // $secretKey = env("PAYMENT_SECRET_KEY");
        $accessId = "id_test_d5bd53ae55d54349915fd0c69f53f3ba69ce13afa3f=";
        $secretKey = "sk_test_09ff807e9a6e43eb8d9593e63c2d896b5dbf0fbbdf1=";
        $client = new PayabbhiClient($accessId, $secretKey);


        $data['user_id'] =  auth('api')->user()->id;
        $data['user_type'] =  'customer';
        $data['agent_charge'] =  '0.00';
        $merchantOrderID = uniqid();
        $data['merchant_order_id'] =  $merchantOrderID;

        if($request->fees_mode == 1){
         $data['amount_payable'] = intval($request->consultation_fees)+intval($request->service_charge);
        }
         else{
            $data['amount_payable'] = intval($request->service_charge);
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
            if($insData = TempBooking::updateOrCreate($data))
            {
                $temp['doctor_id'] =  $request->doctor_id;
                $temp['clinic_id'] =  $request->clinic_id;
                $temp['schedule_id'] =  $request->slot_id;
                $temp['date'] =  $date;
                TempSlotBook::updateOrCreate($temp);
                DB::commit();
                $tempBooking = TempBooking::with('doctor','clinic')->findOrFail($insData->id);
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
    }
    catch (\Exception $e)
    {

        DB::rollback();
        return response()->json(['success'=>false]);
    }

        return response()->json(['success'=>true,'payment_data'=>$payment_data]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finalBook(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'payment_id' => 'required',
            'order_id' => 'required',
            'payment_signature' => 'required'
        ]);
        if ($validator->fails())
        return response()->json(['success'=>false,'error'=>$validator->errors()]);

        try{
             $tempBook = TempBooking::where('order_id',$request->order_id)->first();
        }
        catch (\Payabbhi\Error\SignatureVerification $e) {
            return response()->json(['success'=>false,'message'=>'Unable to find booking id']);
        }
        try{
            //$accessId = env("PAYMENT_ACCESS_ID");
            //$secretKey = env("PAYMENT_SECRET_KEY");
            $accessId = "id_test_d5bd53ae55d54349915fd0c69f53f3ba69ce13afa3f=";
            $secretKey = "sk_test_09ff807e9a6e43eb8d9593e63c2d896b5dbf0fbbdf1=";
            $api = new PayabbhiClient($accessId, $secretKey);
            $api->utility->verifyPaymentSignature([
                'payment_id'    => $request->get("payment_id"),
                'order_id'      => $request->get("order_id"),
                'payment_signature' => $request->get("payment_signature"),
            ]);
            $payment = $api->payment->retrieve($request->get("payment_id"));
            // verification passed
            //dd($payment);
            }
            catch (\Payabbhi\Error\SignatureVerification $e) {
            // verification failed
            return response()->json(['success'=>false,'message'=>'Payment Details fetching error. Wait sometimes or contact to helpline no.']);
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
            $data['user_id'] =   auth('api')->user()->id;
            $data['user_type'] = 'customer';
            $data['order_id'] = $payment->order_id;
            $data['payment_amount'] = ($payment->amount)/100;
            $data['payment_status'] = $payment->status;

            if($booking = Booking::firstOrCreate($data)){
                //dd($booking);
                if ($booking->wasRecentlyCreated) {
                   TempBooking::findOrFail($tempBook->id)->update(['status'=>1,'payment_done'=>1,'online_payment_successes_id'=>$booking->id]);
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
           // return response()->json(['success'=>true,'booking_details'=>$booking,'doctor_details'=>$doctor,'clinic_details'=>$clinic,'schedule_details'=>$schedule]);
           return response()->json(['success'=>true,'message'=>'Thank You']);
        }
    }
    catch (Exception $e){
        DB::rollback();
        return response()->json(['success'=>false,'message'=>'Something went wrong']);
    }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePic(Request $request)
    {
        //
        $departments = Department::get();

        foreach($departments as $key=>$val){
            Department::where('id',$val->id)->update(['app_picture'=>'https://bookurdoc.com/public/images/app/'.$val->picture]);
        }
    }

    public function myOrders()
    {
        //
        $bookings = Booking::with('doctor','clinic','slot')->where([['status','!=',9],['user_id',auth('api')->user()->id],['user_type','customer']])->orderBy('id','desc')->get();
        foreach($bookings as $key=>$value){
            if($value->date > date('Y-m-d') && $value->status==1){
                $bookings[$key]['cancellation_status'] = 1;
            }
            else
                $bookings[$key]['cancellation_status'] = 0;
        }
        return response()->json(['success'=>true,'bookings'=>$bookings]);
    }

    public function cancelOrder(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'remarks' => 'required'
        ]);
        if ($validator->fails())
        return response()->json(['success'=>false,'error'=>$validator->errors()]);

        $user_id = auth('api')->user()->id;
        $date_time = date('Y-m-d H:i:s');
        $remarks = $request->remarks;

        DB::beginTransaction();
        try{
            Booking::where('id',$request->id)->update(['status'=>2,'cancelled_by'=>$user_id,'cancelled_user_type'=>'customer','cancellation_remarks'=>$remarks,
                'cancellation_date'=>$date_time]);
            $message = "";
            $bookingDetails = BookingDetail::where('id',$request->id)->first();
            $message .= "www.bookurdoc.com\n";
            $message .= "Your booking ".$bookingDetails->transaction_id." has been cancelled.For any query call 8812907328/8876657929";
         }
        catch (Exception $e){
            DB::rollback();
            return response()->json(['success'=>false,'message'=>'Something went wrong']);
        }
       DB::commit();
       sendSMS($bookingDetails->patient_phone,$message);
       return response()->json(['success'=>true,'message'=>'Cancelled successfully']);
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
