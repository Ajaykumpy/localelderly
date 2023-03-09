<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CallLog;
use App\Models\CallRequest;
use App\Models\Prescription;
use App\Models\PatientCallRequest;
use App\Models\User;
use App\Helpers\UploadHandler;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $users=User::when('filter',function($q){
                if(request()->has('subscriber') && !empty(request()->subscriber)){
                    if(request()->subscriber=='unsubscribed'){
                        $q->doesntHave('packageSubscriptions');
                        // $q->whereHas('packageSubscriptions',function($sq){
                        //     $sq->whereNull('ends_at');
                        //     $sq->whereNull('starts_at');                            
                        // });
                    }
                    if(request()->subscriber=='subscribed'){
                        $q->whereHas('packageSubscriptions',function($sq){
                            $sq->whereNotNull('ends_at')->where('ends_at','>=',now());
                        });
                    }
                    if(request()->subscriber=='expired'){
                        $q->whereHas('packageSubscriptions',function($sq){
                            $sq->whereNotNull('ends_at')->where('ends_at','<',now());
                        });
                    }
                }
                else{
                    $q->whereHas('packageSubscriptions',function($sq){
                        $sq->whereNotNull('ends_at')->where('ends_at','>=',now());
                    });
                }
            });
            return datatables()->of($users)->addColumn('action',function($data){
                return '<div class="actions">
                            <a class="text-black" href="'.route('admin.patient.show',$data->id).'">
                                <i class="feather-eye me-1"></i> View
                            </a>
                            <a class="text-black" href="'.route('admin.patient.edit',$data->id).'">
                                <i class="feather-edit-3 me-1"></i> Edit
                            </a>
                            <a class="text-danger delete-speciality pointer-link d-none" data-id="'.$data->id.'">
                                <i class="feather-trash-2 me-1"></i> Delete
                            </a>
                        </div>';
            })->addColumn('subscriptions',function($data){
                //activePackageSubscriptions it will check for user subcription validity
                $subscriptions=$data->activePackageSubscriptions();
                if($subscriptions->count()>0){
                    //here we got data in collection so checking ends_at is null or not
                    $subscriptions=$subscriptions->filter(function($items){
                        return $items->ends_at!=null;
                    });
                }
                // if else is made here to handle request comming from subscribed or unsuscribed page
                if($subscriptions->first()){
                     //for suscribed page request
                    $package_name = \App\Models\Package::find($subscriptions->first()->package_id)->name??'NA';
                    return $package_name??'NA';
                }else{
                    //for unsuscribed page request
                    return 'NA';
                }

            })
            ->editColumn('created_at','{{\Carbon\Carbon::parse($created_at)->format("d-m-Y")}}')->make(true);
        }
        $users = User::all();
        $count = $users->count();
        return view('admin.patient.index',compact('users','count'));
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
        if(request()->ajax()){
            if(request()->has('type') && request()->type=='prescription'){
                $prescription=Prescription::with(['patient','doctor','symptom'])->where('patient_id',request()->patient_id);
                return datatables()->of($prescription)->addColumn('action',function($data){
                    return '<div class="actions">
                            <a href="'.route("admin.prescription.show",$data->prescription_id).'" class="text-black">
                            <i class="feather-eye me-1"></i> View
                            </a>
                            </div>';
                })->make(true);
            }
            if(request()->has('type') && request()->type=='call_requests'){
                $call_request=CallRequest::with('doctor')->where('patient_id',request()->patient_id);
                return datatables()->of($call_request)->addColumn('action',function($data){
                    return '<div class="actions">
                            <a href="'.route("admin.call_request.show",$data->id).'" class="text-black">
                            <i class="feather-eye me-1"></i> View
                            </a>
                            </div>';
                })->make(true);
            }
            if(request()->has('type') && request()->type=='emergency_call_log'){
                $call_log=CallLog::with(['video_url'=>function($q){
                    //$q->where('type','Patient');
                }])->where('user_id',request()->patient_id)
				->where('type','patient');
                return datatables()->of($call_log)->make(true);
            }
			if(request()->has('type') && request()->type=='location_log'){
                $location_log=\Spatie\Activitylog\Models\Activity::causedBy(User::find($id));
                return datatables()->of($location_log)->addColumn('address',function($data){
					return $data->properties;
				})->make(true);
            }
            if(request()->has('type') && request()->type=='booked_appointment'){
                $appointment=PatientCallRequest::with('patient','doctor.profile','symptoms')->where('user_id',request()->patient_id);
                return datatables()->of($appointment)->make(true);
            }
        }
        $user=User::findOrFail($id);
        return view('admin.patient.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::find($id);
        //$users->name=\Crypt::decryptString($users->name);
        //$users->email=\Crypt::decryptString($users->email);
        //$users->mobile=\Crypt::decryptString($users->mobile);
        return view('admin.patient.edit',compact('users'));
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

        $users = User::find($id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->mobile = $request->mobile;
        $users->room_no = $request->room_no;
        $users->street_name = $request->street_name;
        $users->location = $request->location;
        $users->gender = $request->gender;
        $users->age = $request->age;
        $users->height = $request->height;
        $users->weight = $request->weight;
        $users->existing_disease = $request->existing_disease;
        $users->blood_group = $request->blood_group;
        if($request->hasFile('image')){
            $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/patient/image/','upload_url'=>asset('uploads/patient/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|webp)$/i',]);
            $users->image=$upload->get_response()['image'][0]->url;
        }
        $users->status = $request->status;
        $users->save();
        // dd($users);
        if(!$users){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('admin.patient.index')->with('success', 'Saved Successfully');
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
            $users = User::destroy($request->id);
            if(!$users){
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

}
