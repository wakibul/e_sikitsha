<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator, Redirect, Auth, Crypt, File, Session;
use App\Models\Region;
use App\Models\Clinic;
use App\Models\Department;
use App\Models\Specialization;
use App\Helper\Slug;
use App\Models\DoctorMaster;
use App\Models\ScheduleMaster;
use App\Models\DailyAvailable;
use App\Models\DoctorClinic;
use App\Models\Note;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $id = 1;
        $doctors = DoctorMaster::with(['department' => function ($query) {
            return $query->select('id', 'name');
        }, 'available.schedule'])->orderBy('department_id','asc')->paginate();
        return view('admin.doctor.index', compact('doctors'));


        //Joining Query with select and whereHas
        // $id = 1;
        // $doctors = DoctorMaster::with(['department'=>function($query){
        //     return $query->select('id','name');
        // },'available.schedule'])->whereHas('department',function($query) use($id){
        //     return $query->where('id',$id);
        // })->paginate();
        // //dd($doctors);
        // return view('admin.doctor.index',compact('doctors'));
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
        $clinics = Clinic::get();
        $departments = Department::get();
        return view('admin.doctor.create', compact('cities', 'clinics', 'departments'));
    }

    public function edit(DoctorMaster $doctor)
    {
        $cities = Region::get();
        $clinics = Clinic::get();
        $departments = Department::get();
       // dd($doctor);
        return view('admin.doctor.edit', compact('cities', 'clinics', 'departments','doctor'));
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
        $validator = Validator::make($data = $request->all(), DoctorMaster::$rules);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        $doctor['name'] = $request->name;
        $doctor['department_id'] = $request->department_id;
        $doctor['email'] = $request->email;
        $doctor['phone_no'] = $request->phone_no;
        $doctor['current_city'] = $request->current_city;
        $doctor['experience'] = (intval($request->year) * 12) + intval($request->month);
        $doctor['qualification'] = $request->qualification;
        $doctor['licence_no'] = $request->licence_no;
        $doctor['doctor_fees'] = $request->doctor_fees;
        $doctor['booking_charge'] = $request->booking_charge;
        $doctor['agent_charge'] = $request->agent_charge;
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
                dd($e);
                return Redirect::back()->with('message', $e->getMessage());
            }
        }
        DB::beginTransaction();
        try {

            if ($doctorMaster = DoctorMaster::create($doctor)) {

                if (!empty($request->days)) {
                    foreach ($request->days as $key => $day) {
                        //dd($request->schedule[$day]);
                        foreach ($request->schedule[$day]['starttime'] as $k => $val) {

                            $schedule['doctor_id'] = $doctorMaster->id;

                            $schedule['starttime'] = $val;
                            $schedule['endtime'] = $request->schedule[$day]['endtime'][$k];
                            $schedule['clinic_id'] = $request->schedule[$day]['clinic_id'][$k];
                            $schedule['days'] = $day;
                            $schedule['slot'] = date('h:i A', strtotime($val)) . "-" . date('h:i A', strtotime($request->schedule[$day]['endtime'][$k]));
                            $schedule['max_booking'] = $request->schedule[$day]['max_booking'][$k];
                            $schedule['book_before_days'] = $request->schedule[$day]['book_before_days'][$k];
                            $schedule['book_before_time'] = $request->schedule[$day]['book_before_time'][$k];
                            $schedule['sms_time']  = $request->schedule[$day]['sms_time'][$k];

                            ScheduleMaster::create($schedule);
                            //dump($request->schedule[$day]['endtime'][$k]);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            Session::flash('error', 'Something Went Wrong');
            return back();
        }

        DB::commit();
        return Redirect::back()->with('success', 'Doctor has been added successfully');
    }

    public function makeAvailable(Request $request)
    {
        //dd($request->doctor_id);
        $doctorMaster = DoctorMaster::findOrFail($request->doctor_id);
        $doctor_id = $doctorMaster->id;
        $dr_available_days = ($doctorMaster->dr_available_days)*7;
        //dd($dr_available_days);
        $max_date = date('Y-m-d', strtotime($request->from_date . '+ ' . $dr_available_days . ' days'));
        $daily_avalables = DailyAvailable::where([['doctor_id', $request->doctor_id], ['status', 1]])->get();
        DB::beginTransaction();
        try {
            //if(count($daily_avalables)==0){
            $all_days = getDatesFromRange($request->from_date, $max_date);
           // dd($max_date);
            foreach ($all_days as $key => $day) {
                $schedules =  ScheduleMaster::where('doctor_id', $doctor_id)->get();
                foreach ($schedules as $key => $schedule) {
                    $d = date('l', strtotime($day));
                    //dd($d);
                    if ($d == $schedule->days) {
                        //dd('hi');
                        $data['doctor_id']  = $doctor_id;
                        $data['schedule_id']  = $schedule->id;
                        $data['clinic_id']  = $schedule->clinic_id;
                        $data['date']  = date('Y-m-d', strtotime($day));
                        $data['sms_time']  =  $schedule->sms_time;
                        $data['available_seat']  = $schedule->max_booking;
                        DailyAvailable::create($data);
                    }
                }
                //}
            }
        } catch (Exception $e) {
            //dd('so so');
            DB::rollback();
            Session::flash('error', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        return back()->with('success', 'Dr is available now');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function viewAvailable(DoctorMaster $doctor)
    {
        //
        $availables = DailyAvailable::with('schedule.clinic')->where('doctor_id', $doctor->id)->where('date', '>=', date('Y-m-d'))->paginate();
        //dd($schedule);
        return view('admin.doctor.view-available', compact('availables', 'doctor'));
    }

    public function dayUnAvailable($id)
    {
        //
        $id = Crypt::decrypt($id);
        DB::beginTransaction();
        try {
            DailyAvailable::findOrFail($id)->update(['status' => 0]);
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        return Redirect::back()->with('success', 'Task Sucessfull');
        // dd($id);
    }

    public function dayAvailable($id)
    {
        //
        $id = Crypt::decrypt($id);
        DB::beginTransaction();
        try {
            DailyAvailable::findOrFail($id)->update(['status' => 1]);
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('error', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        return Redirect::back()->with('success', 'Task Sucessfull');
        // dd($id);
    }

    public function addRemark(DoctorMaster $doctor,$clinic_id)
    {
        $clinic_id = Crypt::decrypt($clinic_id);
        $clinic = Clinic::where('id',$clinic_id)->first();
        return view('admin.doctor.add-remarks',compact('clinic','doctor'));

    }

    public function addRemarkStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required',
            'clinic_id' => 'required',
            'remarks' => 'required'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        try{
        ScheduleMaster::where([['doctor_id',$request->doctor_id],['clinic_id',$request->clinic_id]])->update(['remarks'=>$request->remarks]);
        }
        catch (Exception $e) {
            DB::rollback();
            Session::flash('error', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        return Redirect::back()->with('success','Remark added successfully');
    }

    public function removeRemark($doctor_id,$clinic_id)
    {

        $clinic_id = Crypt::decrypt($clinic_id);
        try{
        ScheduleMaster::where([['doctor_id',$doctor_id],['clinic_id',$clinic_id]])->update(['remarks'=>null]);
        }
        catch (Exception $e) {
            DB::rollback();
            Session::flash('error', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        return Redirect::back()->with('success','Remark removed successfully');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
        $id = Crypt::decrypt($id);
        $validator = Validator::make($data = $request->all(), DoctorMaster::$rules);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        $doctor['name'] = $request->name;
        $doctor['department_id'] = $request->department_id;
        $doctor['email'] = $request->email;
        $doctor['phone_no'] = $request->phone_no;
        $doctor['current_city'] = $request->current_city;
        $doctor['experience'] = (intval($request->year) * 12) + intval($request->month);
        $doctor['qualification'] = $request->qualification;
        $doctor['licence_no'] = $request->licence_no;
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
                dd($e);
                return Redirect::back()->with('message', $e->getMessage());
            }
        }
        DB::beginTransaction();
        try {
            DoctorMaster::findOrFail($id)->update($doctor);
            DB::commit();
            return Redirect::route('admin.doctor.index')->with('success','Doctor updated successfully');
        }
        catch (\Exception $e) {
            DB::rollback();
            dd($e);
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
        DB::beginTransaction();
        try{
            DoctorMaster::findOrFail($id)->delete();
            DB::commit();
            return Redirect::back()->with('success','Doctor Deleted');
        }
        catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }

    }

    public function addFees(doctorMaster $doctor){
       // dd($doctor);
       $scheduleMaster = ScheduleMaster::with('clinic.region')->distinct('clinic_id')->where('doctor_id',$doctor->id)->get();
       return view('admin.doctor.clinics',compact('doctor','scheduleMaster'));
    }

    public function editFees(doctorMaster $doctor){
        $scheduleMaster = ScheduleMaster::with('clinic.region')->distinct('clinic_id')->where('doctor_id',$doctor->id)->get();

        return view('admin.doctor.edit-clinics',compact('doctor','scheduleMaster'));
     }



    public function storeFees(Request $request,$id)
    {
       $id = Crypt::decrypt($id);
       $count = DoctorClinic::where([['doctor_id',$id],['status','1']])->count();
       if($count>0){
        return back()->withErrors('Charges are already added');
       }
       $data['doctor_id'] = $id;
       DB::beginTransaction();
        try {
                foreach($request->clinic_id as $key=>$val)
                {
                        $data['clinic_id'] = $val;
                        $data['doctor_fees'] = $request->doctor_fees[$key];
                        $data['booking_charge'] = $request->booking_charge[$key];
                        $data['agent_charge'] = $request->agent_charge[$key];
                        DoctorClinic::create($data);
                }
            }
        catch (Exception $e) {
            DB::rollback();
            Session::flash('error', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        return back()->with('success', 'Charges are applied successfully');

    }

    public function updateFees(Request $request,$id)
    {
       $id = Crypt::decrypt($id);
       $data['doctor_id'] = $id;
       DB::beginTransaction();
        try {
                foreach($request->clinic_id as $key=>$val)
                {
                        //$data['clinic_id'] = $val;
                        $data['doctor_fees'] = $request->doctor_fees[$key];
                        $data['booking_charge'] = $request->booking_charge[$key];
                        $data['agent_charge'] = $request->agent_charge[$key];
                        DoctorClinic::where([['doctor_id',$id],['clinic_id',$val]])->update($data);
                }
            }
        catch (Exception $e) {
            DB::rollback();
            Session::flash('error', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        return back()->with('success', 'Charges are updated successfully');

    }

    public function viewSchedule(Request $request,DoctorMaster $doctor)
    {
       //dd($doctor);
       $schedule = ScheduleMaster::with('clinic')->where('doctor_id',$doctor->id)->orderBy('days','desc')->get();
       return view('admin.doctor.view-schedule',compact('doctor','schedule'));

    }


    public function editSchedule(Request $request,$id)
    {
       $id = Crypt::decrypt($id);
       $schedule = ScheduleMaster::findOrFail($id);
       return view('admin.doctor.edit-schedule',compact('schedule'));

    }

    public function updateSchedule(Request $request,$id)
    {
       $id = Crypt::decrypt($id);
       DB::beginTransaction();
       try {
       $data['days'] = $request->days;
       $data['starttime'] = $request->starttime;
       $data['endtime'] = $request->endtime;
       $data['book_before_days'] = $request->book_before_days;
       $data['book_before_time'] = $request->book_before_time;
       $data['max_booking'] = $request->max_booking;
       $data['sms_time'] = $request->sms_time;
       $data['slot'] = date('h:i:s A',strtotime($request->starttime))."-".date('h:i:s A',strtotime($request->endtime));;
       ScheduleMaster::findOrFail($id)->update($data);
       DailyAvailable::where('schedule_id',$id)->update(['sms_time'=>$request->sms_time]);
       $schedule = ScheduleMaster::findOrFail($id);
       }
       catch (Exception $e) {
        DB::rollback();
        Session::flash('error', 'Something Went Wrong');
        dd($e->getMessage());
        //return back();
        }
        DB::commit();
        Session::flash('success', 'Updated Successfully');
       return view('admin.doctor.edit-schedule',compact('schedule'));

    }

    public function addMoreSchedule(DoctorMaster $doctor)
    {
        $cities = Region::get();
        $clinics = Clinic::get();
        $departments = Department::get();
        return view('admin.doctor.add-more-schedule', compact('doctor','cities'));

    }

    public function deleteSchedule($id)
    {
        DB::beginTransaction();
        try
        {
            $id = Crypt::decrypt($id);
            ScheduleMaster::findOrFail($id)->delete();
        }
        catch (Exception $e) {
            DB::rollback();
            dd($e);
            Session::flash('error', 'Something Went Wrong');
            return back();
        }

        DB::commit();
        return Redirect::back()->with('success', 'Schedule deleted');

    }

    public function storeMoreSchedule(Request $request,$id)
    {
        $id = Crypt::decrypt($id);
        DB::beginTransaction();
        try {
                if (!empty($request->days)) {
                    foreach ($request->days as $key => $day) {
                        //dd($request->schedule[$day]);
                        foreach ($request->schedule[$day]['starttime'] as $k => $val) {
                            $schedule['doctor_id'] = $id;
                            $schedule['starttime'] = $val;
                            $schedule['endtime'] = $request->schedule[$day]['endtime'][$k];
                            $schedule['clinic_id'] = $request->schedule[$day]['clinic_id'][$k];
                            $schedule['days'] = $day;
                            $schedule['slot'] = date('h:i A', strtotime($val)) . "-" . date('h:i A', strtotime($request->schedule[$day]['endtime'][$k]));
                            $schedule['max_booking'] = $request->schedule[$day]['max_booking'][$k];
                            $schedule['book_before_days'] = $request->schedule[$day]['book_before_days'][$k];
                            $schedule['book_before_time'] = $request->schedule[$day]['book_before_time'][$k];
                            ScheduleMaster::create($schedule);
                            $DoctorClinic['doctor_id'] = $id;
                            $DoctorClinic['clinic_id'] = $request->schedule[$day]['clinic_id'][$k];
                            $DoctorClinic['doctor_fees'] = '0.00';
                            $DoctorClinic['booking_charge'] = '0.00';
                            $DoctorClinic['agent_charge'] = '0.00';
                            DoctorClinic::create($DoctorClinic);

                            //dump($request->schedule[$day]['endtime'][$k]);
                        }
                    }
                }
        } catch (Exception $e) {
            DB::rollback();
            //dd($e);
            Session::flash('error', 'Something Went Wrong');
            return back();
        }

        DB::commit();
        return Redirect::back()->with('success', 'A new schedule has been  added successfully');

    }
    public function order()
    {
        //
        $departments = Department::orderBy('listorder','asc')->get();
        return view('admin.doctor.department',compact('departments'));
    }

    public function viewDeptDoctors($id){
        $department_id = Crypt::decrypt($id);
        $department = Department::where('id',$department_id)->first();
        $doctors = DoctorMaster::where('department_id',$department_id)->orderBy('listorder','asc')->get();
        return view('admin.doctor.view-department-doctors',compact('doctors','department'));
    }

    public function postOrder(request $request)
    {
        $array	= $request->arrayorder;
        if ($request->update == "update"){
            $count = DoctorMaster::max('listorder');
           // dd($count);
            foreach ($array as $id) {
                $count ++;
                DoctorMaster::where('id',$id)->update(['listorder'=>$count]);
               $count ++;
            }
            $depts =  DoctorMaster::where([['listorder','!=','999999'],['department_id',$request->dept_id]])->orderBy('listorder','asc')->get();
            $ctr=1;
            foreach($depts as $key=>$val) {
                DoctorMaster::where('id',$val->id)->update(['listorder'=>$ctr]);
                $ctr = $ctr +1;
            }
            return "<div class='alert alert-success'>All saved! refresh the page to see the changes</div>";
        }
    }

    public function addNote(DoctorMaster $doctor){
        return view('admin.doctor.add-note',compact('doctor'));
    }

    public function postNote(Request $request){
        $data['doctor_id'] = $request->doctor_id;
        $data['notes'] = $request->notes;
        Note::create($data);
        Session::flash('success', 'Note added successfully');
        return back();
    }

    public function removeNote($doctor_id){
        $doctor_id = Crypt::decrypt($doctor_id);
        $notes = Note::where('doctor_id',$doctor_id)->first();
        $notes->delete();
        Session::flash('success', 'Note deleted successfully');
        return back();
    }
}
