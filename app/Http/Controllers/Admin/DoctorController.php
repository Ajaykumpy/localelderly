<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DoctorStatus;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $doctors = Doctor::where('type','normal')->with(['current_status'=>function($q){
                $q->orderBy('updated_at','desc');
            }])->with(['profile','current_status']);

            return datatables()->of($doctors)->addColumn('action',function($data){
                return '<div class="actions">
                            <a class="text-black" href="'.route('admin.doctor.show',$data->id).'">
                                <i class="feather-eye me-1"></i> View
                            </a>
                            <a class="text-black" href="'.url('admin/doctor/login/hours',$data->id).'">
                                <i class="feather-clock me-1"></i> Hours
                            </a>
                        </div>';
            })->make(true);
            //
        }
        $doctors = Doctor::all();
        $count = $doctors->count();
        return view('admin.doctor.index',compact('doctors','count'));
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
        $doctors=Doctor::with(['profile','education','current_status'])->findOrFail($id);
        // dd($doctors);
        return view('admin.doctor.show',compact('doctors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //echo $id;,'specialist'
        $doctors = Doctor::with(['profile'])->find($id);
        return view('admin.doctor.edit',compact('doctors'));
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
        $doctors = Doctor::find($id);
        $doctors->name = $request->name;
        $doctors->email = $request->email;
        $doctors->mobile = $request->mobile;
        // if($request->hasFile('image') && !empty($request->image)){
        //     if($doctors->image) {
        //         //now delete already stored image and then upload new
        //         Storage::delete('public/'.$doctors->image);
        //     }
        //     $doctors->image = $request->file('image')->storeAs('doctor/'.$id.'/education',$request->file('image')->getClientOriginalName(),'public');
        // }
        $doctors->type = $request->type;
        $doctors->save();
        if(!$doctors){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('admin.doctor.index')->with('success', 'Saved Successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($request)
    {
        try {
            $doctors = Doctor::destroy($request->id);
            if(!$doctors){
                return response()->json(['error'=>true,'something went wrong'],500);
            }
            return response()->json(['error'=>true,'message'=>'Deleted Successfully'],200);
        } catch(\Illuminate\Database\QueryException $e) {
            if($e->getCode() == 23000)
            {
              return response()->json(['error'=>true,'something went wrong'],500);
            }
            return response()->json(['error'=>true,'something went wrong'],500);
        }
    }
    /**
     * Approved Doctor Document.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve_doctor_profile($id)
    {
        $doctors = Doctor::where('id',$id)->update(['status'=>1,'document_verified'=>1]);
        if(!$doctors){
            return redirect()->route('admin.doctor.edit',$id)->with('error', 'Something Went wrong');
        }
        return redirect()->route('admin.doctor.edit',$id)->with('success', 'Profile Approved Successfully');
    }

    /**
     * Approved Doctor Document.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve_doctor_document($id)
    {
        $doctors = Doctor::where('id',$id)->update(['status'=>1,'document_verified'=>1]);
        $doctors=Doctor::where('id',$id)->first();
        activity()->causedBy($doctors)->performedOn($doctors)->event('approve doctor firsttime')->useLog('approval')
        ->withProperties(['name'=>$doctors->name,'mobile'=>$doctors->mobile,'email' => $doctors->email])
        ->log('Admin approve doctor');
        if(!$doctors){
            return redirect()->route('admin.doctor.show',$id)->with('error', 'Something Went wrong');
        }
        return redirect()->route('admin.doctor.show',$id)->with('success', 'Doctor Approved Successfully');
    }

    /**
     * Approved Doctor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve_doctor($id)
    {
        $doctors = Doctor::where('id',$id)->update(['ban'=>0]);
        $doctors=Doctor::where('id',$id)->first();
        activity()->causedBy($doctors)->performedOn($doctors)->event('approve doctor')->useLog('approval')
        ->withProperties(['name'=>$doctors->name,'mobile'=>$doctors->mobile,'email' => $doctors->email])
        ->log('Admin approve doctor');
        if(!$doctors){
            return redirect()->route('admin.doctor.show',$id)->with('error', 'Something Went wrong');
        }
        return redirect()->route('admin.doctor.show',$id)->with('success', 'Approved Successfully');
    }


    /**
     * Disable Doctor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable_doctor($id)
    {
        $doctors = Doctor::where('id',$id)->update(['ban'=>1]);
        $doctors=Doctor::where('id',$id)->first();
        activity()->causedBy($doctors)->performedOn($doctors)->event('disable doctor')->useLog('disable')
        ->withProperties(['name'=>$doctors->name,'mobile'=>$doctors->mobile,'email' => $doctors->email])
        ->log('Admin disable doctor');
        if(!$doctors){
            return redirect()->route('admin.doctor.show',$id)->with('error', 'Something Went wrong');
        }
        return redirect()->route('admin.doctor.show',$id)->with('success', 'Disable Successfully');
    }

    /**
     * here we swtich l1 to l2.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function switch_to_l2($id)
    {
        $doctors = Doctor::where('id',$id)->first();
        if($doctors->type != 'normal'){//validation
            return redirect()->route('admin.doctor.show',$id)->with('error', 'Already switched to l2');
        }
        $doctors->type = 'emergency';
        $doctors->save();
        $doctor_type=$doctors->doctor_type()->updateOrCreate([
            'doctor_id'=>$doctors->id
        ],[
            'doctor_id'=>$doctors->id,
            'type'=>'emergency'
        ]);
        activity()->causedBy($doctors)->performedOn($doctors)->event('switch')->useLog('l1 to l2')
                  ->withProperties(['name'=>$doctors->name,'mobile'=>$doctors->mobile,'email' => $doctors->email])
                  ->log('Admin swtiched l1 to l2');
        if(!$doctors){
            activity()->causedBy($doctors)->performedOn($doctors)->event('switch failed')->useLog('l1 to l2')
                  ->log('Admin swtiched l1 to l2 failed');
            return redirect()->route('admin.doctor.show',$id)->with('error', 'Something Went wrong');
        }
        return redirect()->route('admin.emergency_doctor.index')->with('success', 'Switched to L2 Successfully');
    }




    /**
     * Show l1 doctor working hours.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function working_hours($id)
    {
        if(request()->ajax()){
            $doctors = DoctorStatus::where('doctor_id',$id)->get();
            return datatables()->of($doctors)->make(true);
        }
        $doctors = DoctorStatus::where('doctor_id',$id)->get();
        $count = $doctors->count();
        return view('admin.doctor.working-hour',compact('doctors','count'));
    }
}
