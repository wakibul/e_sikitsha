<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator, Redirect, Auth, Crypt;
use App\Models\Region;
use App\Models\CLinic;
use App\Models\RechargeTransaction;
use App\User;
use Illuminate\Validation\Rule;
use App\Models\BookingDetail;
class FranchiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::with('recharge')->where('status','!=',9)->paginate();
        //dd($users);
        return view('admin.franchise.index',compact('users'));
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
        return view('admin.franchise.create',compact('cities'));
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
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
            'password' => 'required|confirmed',
            'phone' => 'required|unique:users',
            'email' => 'email|unique:users',
            'amount' => 'required'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
         DB::beginTransaction();
        try{
            $data['name'] = $request->name;
            $data['type'] = 'franchise';
            $data['email'] = $request->email;
            $data['phone'] = $request->phone;
            $data['city'] = $request->city;
            $data['password'] = bcrypt($request->password);
            $data['amount'] = $request->amount;
            $data['address'] = $request->address;
            if($user = User::create($data)){
                $transaction['franchise_id'] = $user->id;
                $transaction['amount'] = $user->amount;
                $transaction['type'] = 'o';
                if(RechargeTransaction::create($transaction)){
                    DB::commit();
                    return Redirect::back()->with('success','New franchise added successfully');
                }
            }

        }
        catch (\Exception $e) {
             DB::rollback();
              dd($e->getMessage());
            }


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

     public function suspend($id)
    {
        //
        $id = Crypt::decrypt($id);
        DB::beginTransaction();
        try{
            User::where('id',$id)->update(['status'=>0]);
            DB::commit();
            return Redirect::back()->with('success','User suspended successfully');
        }
        catch (\Exception $e) {
             DB::rollback();
              dd($e->getMessage());
            }

    }


     public function activate($id)
    {
        //
        $id = Crypt::decrypt($id);
        DB::beginTransaction();
        try{
            User::where('id',$id)->update(['status'=>1]);
            DB::commit();
            return Redirect::back()->with('success','User activated successfully');
        }
        catch (\Exception $e) {
             DB::rollback();
              dd($e->getMessage());
            }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function viewTransaction($id)
    {
        //
        return view('admin.franchise.transaction');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function filterTransaction(Request $request,$id)
    {
        //
        $id = Crypt::decrypt($id);
        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date',
            'to_date' => 'required|date'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        $rechargeTransaction = RechargeTransaction::where('franchise_id',$id)->whereDate('created_at','>=', $request->from_date)
            ->whereDate('created_at','<=', $request->to_date)->orderBy('id','desc')
            ->get();
        return view('admin.franchise.transaction',compact('rechargeTransaction'));
    }

    public function booking(Request $request,$id)
    {
        return view('admin.franchise.booking');

    }

    public function filterBooking(Request $request,$id)
    {
        $id = Crypt::decrypt($id);
        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date',
            'to_date' => 'required|date'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        $appointments = BookingDetail::where([['user_id',$id],['user_type','franchise']])->whereDate('booking_date','>=', $request->from_date)
        ->whereDate('booking_date','<=', $request->to_date)->orderBy('id','desc')
        ->get();
        return view('admin.franchise.booking',compact('appointments'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function recharge(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'recharge_amount' => 'required'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
        $id = Crypt::decrypt($id);

        $user = User::where('id',$id)->first();
        $total_amount = floatval($user->amount)+floatval($request->recharge_amount);
        DB::beginTransaction();
        try{

            User::where('id',$id)->update(['amount'=>$total_amount]);
            $data['franchise_id'] = $user->id;
            $data['amount'] = $request->recharge_amount;
            $data['type'] = 'r';
            RechargeTransaction::create($data);
            DB::commit();
            $message = "www.bookurdoc.com \n";
            $message .= $user->name." , Your account is recharged with amount of Rs. ".$request->recharge_amount;
            $message .= "\n From Bookurdoc";
            sendSMS($user->phone,$message);
            return Redirect::back()->with('success','Recharged successfully');
        }
        catch (\Exception $e) {
             DB::rollback();
             dd($e->getMessage());
              return Redirect::back()->with('error','something went wrong');
            }

    }

    public function destroy($id)
    {
        //
    }
}
