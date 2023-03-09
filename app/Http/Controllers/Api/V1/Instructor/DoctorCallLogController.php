<?php

namespace App\Http\Controllers\Api\V1\Instructor;

use App\Http\Controllers\Controller;
use App\Models\CallBackStream;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Models\CallLog;

class DoctorCallLogController extends Controller
{
    /**
    * Call log list
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function index(){
        $call_log=CallLog::with('doctor:id,name,email,mobile','patient:id,name,email,mobile')->select('user_id','doctor_id','meeting_id', 'status', 'date', 'time')
                                ->where('doctor_id',auth()->id())
                                ->orderBy('id','desc')
                                ->get();
        if (!$call_log) {
                return response()->json(['error'=>true, 'message'=>'No Call Found']);
        }
        return response()->json([
            'success'=>true,
            'message'=>'Doctor Call Log',
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
           'type'       => 'Doctor',
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

	public function show($id)
    {
		$call_log_data=CallBackStream::where('meeting_id',$id)->get();
		$call_request=\App\Models\CallRequest::where('meeting_id',$id)->first();
		$prescription=\App\Models\Prescription::with(['symptom','medicine'])->where('meeting_id',$id)->first();
		if($call_log_data->count()>0){
			$call_log_data=$call_log_data->map(function($items){
				$items->extra_params=(!empty($items->extra_params))?json_decode(json_decode(json_encode(json_decode($items->extra_params)))):'';
				return $items;
			});
		}
		return response()->json([
            'success'=>true,
			'doctor'=>($call_request && $call_request->doctor)?$call_request->doctor->only(['id','name','email','mobile']):'',
			'patient'=>($call_request && $call_request->patient)?$call_request->patient->only(['id','name','email','mobile']):'',
			'prescription'=>$prescription,
            'data'=>$call_log_data
        ]);
    }


}
