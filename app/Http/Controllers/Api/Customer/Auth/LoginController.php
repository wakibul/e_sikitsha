<?php
namespace App\Http\Controllers\Api\Customer\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTFactory;
use JWTAuth,JWTException;
use Validator,DB;
use App\Customer;

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
		$credentials = $request->only('phone', 'password');
		$credentials['is_active'] = 1;
		 try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = auth('api')->attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'Your username or password is incorrect']);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
        $customer = Customer::findOrFail(auth('api')->user()->id);
        return response()->json(['success' => true, 'token' => $token,'doctor'=>$customer]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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
