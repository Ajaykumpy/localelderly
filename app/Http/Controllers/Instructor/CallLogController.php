<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CallLog;
use App\Models\Speciality;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Doctor;

class CallLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $calllog=CallLog::with(['patient','doctor'])->where('doctor_id',auth()->id())
            ->when('filter',function($q){
                if(request()->has('doctors') && !empty(request('doctors'))){
                    $q->where('doctor_id',request('doctors'));
                }
                if(request()->has('users') && !empty(request('users'))){
                    $q->where('user_id',request('users'));
                }
                if(request()->has('status') && !empty(request('status'))){
                    $q->where('status',request('status'));
                }
                if(request()->has('start_date') && !empty(request('start_date'))){
                    $q->whereDate('created_at','>=',request('start_date'));
                }
                if(request()->has('end_date') && !empty(request('end_date'))){
                    $q->whereDate('created_at','<=',request('end_date'));
                }
                return $q;
			});
            return datatables()->of($calllog)->addColumn('action',function($data){
                return '<div class="actions">
                            <a class="text-black" href="'.route('doctor.call_log.show',$data->id).'">
                                <i class="feather-eye me-1"></i> Show
                            </a>
                        </div>';
            })->make(true);
        }
        // $doctors = Doctor::get();
         $users = User::get();
        return view('doctor.call_log.index',compact('users'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $call_log = CallLog::with('call_request','video_url','doctor.profile','doctor.specialist','appointment')->find($id);
        $user = User::where('id',$call_log->user_id)->first();
        return view('doctor.call_log.show',compact('call_log','user'));
    }

    /**
     * Create a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //   return view('admin.package.create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $calllog=new Package();
    //     $calllog->package_name=$request->package_name;
    //     $calllog->no_of_devices=$request->no_of_devices;
    //     $calllog->month=$request->month;
    //     $calllog->image=$request->file('image')->storeAs('package/image',$request->file('image')->getClientOriginalName(),'public');
    //     $calllog->price=$request->price;
    //     $calllog->status=$request->status;
    //     $calllog->save();
    //     if (!$calllog) {
    //         return redirect()->back()->with('Something Went Wrong');
    //     }

    //     return redirect()->route('admin.package.index')->with('success','Saved Successfully');


    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     $calllog = Package::find($id);
    //     return view('admin.package.edit',compact('calllog'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    // //    dd($request->all());
    //     $calllog=Package::find($id);
    //     $calllog->package_name = $request->package_name;
    //     $calllog->no_of_devices = $request->no_of_devices;
    //     $calllog->month = $request->month;
    //     $calllog->price = $request->price;
    //     if ($request->hasFile('image') && !empty($request->image)) {
    //         if ($calllog->image) {
    //             //
    //             Storage::delete('/public'.$calllog->images);
    //         }
    //         $calllog->image=$request->file('image')->storeAs('calllog', $request->file('image')->getClientOriginalName(),'public');
    //     }
    //     $calllog->status = $request->status;
    //     $calllog->save();
    //     if(!$calllog){
    //         return redirect()->back()->with('error', 'Something went wrong');
    //     }
    //     return redirect()->route('admin.package.index')->with('success', 'Saved Successfully');


    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($calllog)
    // {
    //     $calllog->delete();

    //     return redirect()->route('admin.package.index')
    //         ->with('success','Student deleted successfully.');
    // }

    // /**
    //  * get the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function getSpeciality()
    // {
    //     // $Speciality = Speciality::select('id','name','image')->where('status',1)->get();
    //     // if(!$Speciality){
    //     //     return response()->json(['error'=>true, 'Speciality'=>$Speciality],422);
    //     // }
    //     // return response()->json(['success'=>true, 'Speciality'=>$Speciality],200);
    // }
}
