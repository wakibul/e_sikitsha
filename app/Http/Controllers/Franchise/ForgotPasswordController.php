<?php

namespace App\Http\Controllers\Franchise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator,Redirect,DB,Session,Crypt,Auth;
class ForgotPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('franchise.forgot-password');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendOtp(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        $user = User::where([['phone',$request->phone],['status',1]])->first();
        if($user == null){
            Session::flash('error', 'The account with this phone no. does not exists!');
            return Redirect::back();
        }
        DB::beginTransaction();
        try {
            $otp = rand('111111','999999');
            User::where('id',$user->id)->update(['otp'=>$otp]);
            $message = "Your otp to change password is ".$otp;
            sendSMS($user->phone, $message);
        }
        catch (Exception $e) {
            //dd('so so');
            DB::rollback();
            Session::flash('error', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        return view('franchise.validate-otp',compact('user'));
    }

    public function validateOtp(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        $user = User::where([['id',$request->user_id],['status',1]])->first();
        if($user == null){
            Session::flash('error', 'The account does not exists!');
            return Redirect::back();
        }
        if($request->otp == $user->otp){
            //return view('franchise.change-password',compact('user'));
            return Redirect::route('franchise.login.change_password',Crypt::encrypt($user->id));
        }
        Session::flash('error', 'Something went wrong');
        return Redirect::back();
        
    }

    public function changePasswordIndex($user_id)
    {
        //
        return view('franchise.change-password',compact('user_id'));
    }

    public function changePassword(Request $request,$user_id)
    {
        //
        $user_id = Crypt::decrypt($user_id);
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        $user = User::where([['id',$user_id],['status',1]])->first();
        if($user == null){
            Session::flash('error', 'The account does not exists!');
            return Redirect::back();
        }
        DB::beginTransaction();
        try {
            $password = bcrypt($request->password);
            User::where('id',$user->id)->update(['password'=>$password]);
        }
        catch (Exception $e) {
            //dd('so so');
            DB::rollback();
            Session::flash('error', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        Auth::login($user);
        return Redirect::route('index');

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    

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
