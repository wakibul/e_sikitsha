<?php

use App\Models\AvailableDate;
use App\Models\ScheduleMaster;
use App\Models\TempBooking;
use App\Models\BookingDetail;
use App\Models\DoctorClinic;
use App\Models\Department;
use App\Models\Booking;
use App\Customer;
use App\Models\DoctorMaster;
function left($str, $length) {
     return substr($str, 0, $length);
}

function right($str, $length) {
     return substr($str, -$length);
}

function getPaymentGatewayHash($event_id, $name, $email, $amount)
{
	$salt = 'SJ3MCIihxh';
	$key = 'd8Au5XfG';
	$name = ucwords($name);

	$hashSequence = $key . '|' . $event_id . '|' . $amount . '|aa|' . $name . '|' . $email . '|||||||||||' . $salt;
	$hash = hash("sha512", $hashSequence);

	return $hash;
}

function sendMail($viewname, $email, $name, $subject, $data)
{
	try {
		Mail::send(['html' => $viewname], $data, function ($message) use ($email, $name, $subject) {
			$message->to($email, ucwords($name))->subject($subject);
			$message->from('office@anecarrental.com', 'Ane Teavels');
		});
	} catch (\Exception $e) {
		return back();
	}
}

function getDecimal($amount, $upto = 2)
{
    return number_format($amount, $upto);
}

function getDatesFromRange($start, $end, $format = 'Y-m-d') {

    // Declare an empty array
    $array = array();

    // Variable that store the date interval
    // of period 1 day
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    // Use loop to store date into array
    foreach($period as $date) {
        $array[] = $date->format($format);
    }

    // Return the array elements
    return $array;
}

function getAvailableDates($doctor_id,$clinic_id,$date)
{
	$availableDates = AvailableDate::where([['doctor_id',$doctor_id],['clinic_id',$clinic_id],['date','>=',$date],['status',1]])->groupBy('date')->get();
	//dd($availableDates);
	if (!$availableDates->isEmpty()){
		$dates = '';
		foreach($availableDates as $key=>$value){
			if($value->booked_seat != $value->available_seat){
				$dates .= "<span class='label available_dates'><strong>".date('d-M-Y',strtotime($value->date))."</strong></span>";
			}
		}

		return $dates;
	}
	else
		return false;
}

function getDatesForCalender($doctor_id,$clinic_id,$date)
{
	$availableDates = AvailableDate::select('date')->where([['doctor_id',$doctor_id],['clinic_id',$clinic_id],['date','>=',$date],['status',1]])->get();
	//dd($clinic_id);
	if (!$availableDates->isEmpty()){
		$dates = '';
			foreach($availableDates as $key=>$value){
				$dates .= "'".date('d-m-Y',strtotime($value->date))."',";
			}
			return left($dates, -1);
	}
	else
		return false;
}

function getAvailableDays($doctor_id,$clinic_id)
{
	$availableDays = ScheduleMaster::where([['doctor_id',$doctor_id],['clinic_id',$clinic_id],['status',1]])->groupBy('days')->get();
	//dd($availableDays);
	if (!$availableDays->isEmpty())
		{
			$days = '';
			foreach($availableDays as $key=>$value){
				$days .= $value->days.",";
			}
			return left($days, -1);
		}
	else
		return 0;
}

function getIdBySlug($slug,$table)
{
	$data = $table::select('id')->where('slug',$slug)->first();
	if($data)
		return $data->id;
	else
		abort(404);
}

function getAlltiming($day,$doctor_id,$clinic_id)
{
	$data = ScheduleMaster::where('doctor_id',$doctor_id)->where('days',$day)->where('clinic_id',$clinic_id)->get();
	if($data)
		return $data;
	else
		abort(404);
}

function genUniqueID() {
        $is_unique = 0;
        while ($is_unique === 0) {
            try {
	                $randID = "BUD-".mt_rand(111111,999999); // 8 is the number of characters
	                $tempBook = TempBooking::Where('transaction_id',$randID)->count();
	                if($tempBook > 0){
	                	$randID = "BUD-".mt_rand(111111,999999); // 8 is the number of characters
	                }
	                else {
	                    $is_unique = 1;
	                }
	            }
            catch (Exception $e) {
                return $e->getMessage();
                exit();
            }
            return $randID;
        }
 }

 function sendSMS($mobile_no, $message)
{
    $user = 'gallery';
    $password = 'c64af2841aXX';
    $senderid = 'BKUDOC';
    $url = 'http://t.instaclicksms.in/sendsms.jsp';
    $message = urlencode($message);
    $mobile_no = '91' . $mobile_no;
    $smsInit = curl_init($url . "?user=$user&password=$password&mobiles=$mobile_no&sms=" . $message . "&senderid=" . $senderid);
    curl_setopt($smsInit, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($smsInit);

}

function bookingDetails(){
	return BookingDetail::orderBy('id','desc')->where('status',1)->take(20)->get();
}

function checkInitDoctorCharges($doctor_id){
	return $count = DoctorClinic::where('doctor_id',$doctor_id)->count();

}

function getCharges($doctor_id,$clinic_id){
	return DoctorClinic::where([['doctor_id',$doctor_id],['clinic_id',$clinic_id]])->first();

}

function todaysBookings(){
	return Booking::whereDate('created_at',date('Y-m-d'))->count();
}

function totalBookings(){
	return Booking::count();
}

function franchiseBooking(){
	return Booking::where('user_type','franchise')->count();
}

function guestBooking(){
	return Booking::where('user_type','guest')->count();
}

function totalFranchise(){
	return Customer::where('is_active',1)->count();
}

function totalDoctors(){
	return DoctorMaster::count();
}

function getBookNos(){
	//return DoctorMaster::count();
}

function GenerateIds()
{
    return Department::max('listorder');
}
