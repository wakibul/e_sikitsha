<?php

namespace App\Http\Controllers\Api\Customer\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTFactory;
use JWTAuth,JWTException;
use Validator,DB;
use App\Models\Department;
use App\Models\Autocomplete;
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $departments = Department::where('status',1)->get();
        if(!$departments->isEmpty()){
            return response()->json(['success'=>true,'departments'=>$departments]);
        }
        else
            return response()->json(['success'=>false,'message'=>'No records found']);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function departments(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'region_id'=>'required',
            'department_id'=>'required'
        ]);
        if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }

        $autocomplete = Autocomplete::select('doctor_id')->with('doctor.department','doctor.ScheduleMaster:id,clinic_id')->where([['region_id',$request->region_id],['department_id',$request->department_id]])->groupBy('doctor_id')->paginate(10);
        if(!$autocomplete->isEmpty())
            return response()->json(['success'=>true,'data'=>$autocomplete]);
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
