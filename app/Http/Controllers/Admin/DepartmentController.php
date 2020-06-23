<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator, Redirect, Auth, Crypt;
use App\Models\Department;
use App\Helper\Slug;
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
        $departments = Department::orderBy('name','asc')->paginate();
        return view('admin.department.index',compact('departments'));
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
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'picture' => 'required|mimes:jpeg,jpg,png,PNG | max:3000'

        ]);
         if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
         if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $name = preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower($request->name)).time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
        }
        $slug = new Slug();
        $data['slug'] = $slug->createSlug("App\Models\Department",$request->name);
        $data['name'] = $request->name;
        $data['picture'] = $name;
        if(Department::create($data)){
            return Redirect::route('admin.department.index')->with('success','Department added successfully');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $id = Crypt::decrypt($id);
        $department = Department::findOrFail($id);
        return view('admin.department.edit',compact('department'));
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
        $id = Crypt::decrypt($id);
        $department = Department::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'picture' => 'nullable|mimes:jpeg,jpg,png,PNG | max:3000'

        ]);
         if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();
         if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $name = preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower($request->name)).time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
        }
        else{
             $name = $department->picture;
        }
        $slug = new Slug();
        $department->slug = $slug->createSlug("App\Models\Department",$request->name);
        $department->name = $request->name;
        $department->picture = $name;
        if($department->save()){
            return Redirect::route('admin.department.index')->with('success','Department updated successfully');
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
        $department = Department::findOrFail($id)->delete();
        return Redirect::route('admin.department.index')->with('success','Department Deleted');
    }

    public function order()
    {
        $departments = Department::where('status',1)->orderBy('listorder','asc')->get();
        return view('admin.department.order',compact('departments'));
    }

    public function postOrder(request $request)
    {
        $array	= $request->arrayorder;
        if ($request->update == "update"){
            $count = Department::max('listorder');
           // dd($count);
            foreach ($array as $id) {
                Department::where('id',$id)->update(['listorder'=>$count]);
               $count ++;
            }
            $depts =  Department::where('listorder','!=','999999')->orderBy('listorder','asc')->get();
            $ctr=1;
            foreach($depts as $key=>$val) {
                Department::where('id',$val->id)->update(['listorder'=>$ctr]);
                $ctr = $ctr +1;
            }
            return "<div class='alert alert-success'>All saved! refresh the page to see the changes</div>";
        }
    }
}
