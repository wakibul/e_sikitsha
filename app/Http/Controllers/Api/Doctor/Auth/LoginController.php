<?php

namespace App\Http\Controllers\Api\Doctor\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTFactory;
use JWTAuth,JWTException;
use Validator,DB;
use App\Models\DoctorMaster;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
			'phone'=> 'required|numeric',
			'password'=> 'required'
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
		}
		$credentials = $request->only('password');
		$credentials['is_active'] = 1;
		$credentials['phone_no'] = $request->get("phone");
		 try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = auth('doctor')->attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'Your username or password is incorrect']);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
        $doctor = DoctorMaster::findOrFail(auth('doctor')->user()->id);
        return response()->json(['success' => true, 'token' => $token,'doctor'=>$doctor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function isVerified()
    {
        //
        $success = false;
        try {
            $user = auth('doctor')->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            // do something
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }
        
        try {
        if(auth('doctor')->user()->is_verified == 1){
            $success = true;
        }
        return response()->json(['id'=>auth('doctor')->user()->id,'is_verified'=>auth('doctor')->user()->is_verified,'success'=>$success]);
        }
        catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'msg' => $e->getMessage(),'message'=>'Something went wrong']);
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
