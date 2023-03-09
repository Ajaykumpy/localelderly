<?php

namespace App\Http\Controllers\Admin;

use App\Models\CompanyEmployePackage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PackageActivationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $activationcode=CompanyEmployePackage::with(['package'])->get();
            return datatables()->of($activationcode)->editColumn('created_at','{{\Carbon\Carbon::parse($created_at)->format("d-m-Y")}}')->addColumn('action',function($data){
                return '<div class="actions">
                        <a class="text-danger  delete-speciality pointer-link" onclick="pack_act_del('.$data->id.')"  data-id="'.$data->id.'">
                            <i class="feather-trash-2 me-1"></i> Delete
                        </a>
                    </div>';
            })->make(true);
        }
        $count=CompanyEmployePackage::count();
        return view('admin.package-activation.index',compact('count'));
    }

    // <a class="text-black" href="'.route('admin.package-activation.edit',$data->id).'">
    //                         <i class="feather-edit-3 me-1"></i> Edit
    //                     </a>
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activation=CompanyEmployePackage::with(['package']);
        return view('admin.package-activation.create',compact('activation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'name'=>'required',
        //     'description'=>'required',
        //     'price'=>'required'
        // ]);
        $package=new CompanyEmployePackage();
        $package->package_id=$request->package_name??"";
        $package->company_name=$request->company_name;
        $package->user_name=$request->user_name;
        $package->user_mobile=$request->user_mobile;
        $package->user_email=$request->user_email;
       // $package->price=$request->price;
        $package->activation_code=$request->activation_code;
        $package->save();
        if (!$package) {
            return redirect()->back()->with('Something Went Wrong');
        }
        return redirect()->route('admin.package-activation.index')->with('success','Saved Successfully');
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
        $activation=CompanyEmployePackage::find($id);
        return view('admin.package-activation.edit',compact('activation'));
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
        $activationcode=CompanyEmployePackage::updateOrCreate([
            'package_id'=>$request->package_id
        ],[
            'company_name'=>$request->company_name,
            'user_name'=>$request->user_name,
            'user_mobile'=>$request->user_mobile,
            'user_email'=>$request->user_email,
            'activation_code'=>$request->activation_code
        ]);
        if (!$activationcode) {
                return response()->json(['error'=>true,'message','Oops something went wrong']);
        }
        return redirect()->back()->with('message','Activation Code created Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $activation=CompanyEmployePackage::where('id',$request->id)->delete();
       if($activation){
        return response()->json(['success'=>true, 'message'=>'Deleted Successfully'],200);
       }
       return response()->json(['error'=>true, 'message'=>'Something went wrong'],500);
    }
}
