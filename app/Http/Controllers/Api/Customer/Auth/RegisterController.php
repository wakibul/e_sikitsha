<?php

namespace App\Http\Controllers\Api\Customer\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTFactory;
use JWTAuth,JWTException;
use Validator,DB;
use App\Customer;
class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {
        $this->middleware('auth:api')->except('login','register','otp_verify','resend_otp');
        // $this->middleware("auth:api");
        // Log::useFiles(storage_path('app/info_log.txt'), 'info');
    }
	public function register(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'password'=> 'required|min:6|confirmed',
            'phone'=> 'required|numeric'
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
		}
		$otp = mt_rand(100000, 999999);
		DB::beginTransaction();
		try {
			$customerPhoneExist = Customer::where([['phone',$request->phone],['otp_verified','!=',null],['is_active',1]])->first();
			if($customerPhoneExist != null){
				return response()->json(['success'=>false,'error'=>'Phone no already exists']);
			}

			Customer::where([['email',$request->email],['otp_verified','!=',null],['is_active',0]])->orWhere([['phone',$request->phone],['otp_verified','=',null],['is_active',0]])->delete();
				$customer = Customer::create([
					'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
					'password' => bcrypt($request->password),
					'otp' => $otp
				]);
				DB::commit();
				sendSMS($request->phone,"Your otp verification code is ".$otp);
				return response()->json(['success'=>true,'msg'=>'Otp sent succesfully','customer_details'=>$customer->phone]);
			}
		catch (\Exception $e) {
				DB::rollback();
			    return response()->json($e->getMessage());
			}		

    }

    // OTP Verification 
    
    public function otp_verify(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'phone' => 'required|numeric',
			'otp' => 'required|numeric',
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
		}

		$customer = Customer::select('id','name','phone','otp')->where([['phone',$request->phone],['otp_verified',0],['is_active',0]])->first();
		if($customer){
			if($request->otp == $customer->otp){
				$credentials = $request->only('phone');
				$credentials['is_active'] = 1;
				try {
					//$user = Customer::first();
        			$token = JWTAuth::fromUser($customer);
        			$dt = date('Y-m-d H:i:s');
        			Customer::where('phone',$request->phone)->update(['is_active'=>1,'otp_verified'=>1]);
					return response()->json(['success' => true,'token'=>$token,'details'=>$customer]);
				} catch (JWTException $e) {
				            // something went wrong whilst attempting to encode the token
					return response()->json(['success' => false, 'error' => 'Failed to login, please try again.']);
				}
				        // all good so return the token
			}
			else{
				return response()->json(["success"=>false,"msg"=>"Invalid Otp"]);
			}
		}
		else{
			return response()->json(["success"=>false,"msg"=>"Invalid User"]);
		}
        
    }
    
    public function resend_otp(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'phone'=> 'required|numeric'
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
		}
		if (Customer::where([['phone', '=', $request->phone],['is_active',0],['otp_verified',0]])->exists()) {
				$otp = mt_rand(100000, 999999);
				$update = Customer::where([['phone',$request->phone],['is_active',0]])->update(['otp'=>$otp]);
				if($update){
					sendSMS($request->phone,"Your otp verification code is ".$otp);
					return response()->json(['success'=>true,'msg'=>'Otp sent successfully']);
						}
			
			}
			else{
				return response()->json(['success'=>false,'error'=>'The phone no does not exist']);
			}
		
    }
    

    public function index()
    {
        //
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
