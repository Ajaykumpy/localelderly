<?php

namespace App\Http\Controllers\Api\V1\Patient;

use App\Http\Controllers\Controller;
use App\Models\CallBackStream;
use Illuminate\Http\Request;
use App\Models\CallRequest;

use App\Models\PatientCallRequest;

use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Models\CallLog;

class UserCallLogController extends Controller
{
    /**
    * Call log list
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function index(){
        $call_log = CallLog::with('doctor:id,name,email,mobile','patient:id,name,email,mobile')->select('user_id','doctor_id','meeting_id', 'status', 'date', 'time')
                                    ->where('user_id',auth()->user()->id)
                                    ->orderBy('id','desc')
                                    ->get();
        if (!$call_log) {
                return response()->json(['error'=>true, 'message'=>'No Call Found']);
        }
        return response()->json([
            'success'=>true,
            'message'=>'Patient Call Log',
            'data'=>$call_log
        ]);
    }

    /**
    * Store call log
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function store(Request $request){
        $calllog=CallLog::create([
           'user_id'    => auth()->user()->id,
           'date'       => Carbon::today(),
           'time'       => Carbon::now()->toTimeString(),
           'type'       => 'Patient',
           "latitude"   =>  $request->latitude,
           "longitude"  =>  $request->longitude,
           "created_by"  =>  auth()->user()->id,
           "updated_at"  =>  NULL,
        ]);
        if(!$calllog){
            return response()->json([
                'error' => true,
                'message' => 'Something went wrong',
            ],422);
        }
        return response()->json([
            'success' => true,
        ], Response::HTTP_OK);
    }
	public function show_list($meeting_id)
    {

	 $call_log = CallLog::with('doctor:id,name')->select('user_id','doctor_id','meeting_id', 'status', 'date', 'time')
                                        ->where('user_id',auth()->user()->id)->where('meeting_id',$meeting_id)->first();
      // dd($call_log);
        $call_log_data=CallBackStream::where('meeting_id',$meeting_id)->where('type','Doctor')->first();
        $emergency=CallRequest::where('patient_id',auth()->user()->id)->get();
        $patientcallrequest=PatientCallRequest::where('user_id',auth()->user()->id)->get();

        return response()->json([
            'success'=>true,
            'call'=>$call_log,
            'sos'=>$emergency,
            'appointment'=>$patientcallrequest,
            'meeting_id'=> $call_log_data->meeting_id??"",
            'doctor_url' => $call_log_data->replay_url??""
        ]);
    }
    public function show($meeting_id)
    {
       $call_log = CallLog::with('doctor:id,name,email,mobile','patient:id,name,email,mobile','doctor.profile','doctor.education','doctor.specialists:id,name')->select('user_id','doctor_id','meeting_id', 'status', 'date', 'time')
                                       ->where('user_id',auth()->user()->id)
										->where('meeting_id',$meeting_id)
										->first();

       $call_log_data=CallBackStream::where('meeting_id',$meeting_id)->where('type','Doctor')->first();
       return response()->json([
           'success'=>true,
           'call'=>$call_log,
           'meeting_id'=> $call_log_data->meeting_id,
           'doctor_url' => $call_log_data->replay_url
       ]);
    }
}
