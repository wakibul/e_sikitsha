<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Hash,Auth,Redirect,DB;
use App\Admin;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword()
    {
        //
        return view('admin.change-password');
    }

    public function changePasswordStore(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'old_password' => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::guard('admin')->user()->password)) {
                        $fail('Current Password didn\'t match');
                    }
                },
            ],
            'password' => 'required|min:6|confirmed'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        try{
            $password = bcrypt($request->password);
            Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>$password]);
            }
            catch (Exception $e) {
                DB::rollback();
                Session::flash('error', 'Something Went Wrong');
                return back();
            }
            DB::commit();
            Auth::guard('admin')->logout();

            return Redirect::route('admin.login');
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
