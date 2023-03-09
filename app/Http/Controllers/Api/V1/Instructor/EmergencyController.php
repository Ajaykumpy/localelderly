<?php

namespace App\Http\Controllers\Api\V1\Instructor;

use App\Http\Controllers\Controller;
use App\Models\CallRequest;
use App\Models\CallRequestFilter;
use Illuminate\Http\Request;
use App\Models\CallLog;


class EmergencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (version_compare(phpversion(), '7.1', '>=')) {
           ini_set( 'precision', 17 );
           ini_set( 'serialize_precision', -1 );
        }
        $per_page=request()->per_page??10;
        $call_request_filter=CallRequestFilter::join('call_requests','call_requests.id','=','call_request_filters.call_request_id')
                                                ->join('users','users.id','=','call_requests.patient_id')
                                                ->where('call_request_filters.doctor_id',auth()->id())
                                                ->where('call_request_filters.status',0)
                                                ->where('call_requests.status','pending')
                                                ->orderBy('call_request_filters.id','desc')
                                                ->select('users.name','users.email','users.mobile','call_requests.latitude','call_requests.longitude','call_request_filters.*')
                                                ->paginate($per_page);
        return response()->json($call_request_filter);
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

	/**
     * Get record of accepted doctor
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function call_request_cancel_call(Request $request)
    {
        // ->where('patient_id', $request->patient_id)
        $call_request_update = CallRequest::where('meeting_id',$request->meeting_id)->update([
                                        'status'    => 'Completed',
                                        'duration'   => $request->duration
                                    ]);
        // record call log and update doctor id to call log
        $call_log=CallLog::where('meeting_id',$request->meeting_id)->update([
            'status'       => 'Completed',
            'duration'   => $request->duration
        ]);
		//make doctor availabe for next user
		$call_request = CallRequest::where('meeting_id',$request->meeting_id)->first();
		$doctor=\App\Models\Doctor::find($call_request->doctor_id);
		if($doctor){
			$doctor->available=1;
			$doctor->save();
		}
        if(!$call_request_update){
            return response()->json(['error'=>true,'message'=>'Something went wrong'],422);
        }
        return response()->json(['success'=>true,'message'=>'Disconnected Successfully'],200);
    }

	/**
	* Function when call complete
	*/
	public function call_request_complete(Request $request)
    {
        $this->validate($request,[
			'meeting_id'=>'required'
		]);
        $call_request_update = CallRequest::where('meeting_id',$request->meeting_id)->update([
                                        'status'    => 'Completed',
                                        'duration'   => $request->duration
                                    ]);
        // record call log and update doctor id to call log
        $call_log=CallLog::where('meeting_id',$request->meeting_id)->update([
            'status'       => 'Completed',
            'duration'   => $request->duration
        ]);
		//make doctor availabe for next user
		$call_request = CallRequest::where('meeting_id',$request->meeting_id)->first();
		$doctor=\App\Models\Doctor::find($call_request->doctor_id);
		if($doctor){
			$doctor->available=1;
			$doctor->save();
		}
		if(!$call_request_update){
            return response()->json(['error'=>true,'message'=>'Something went wrong'],422);
        }
        return response()->json(['success'=>true,'message'=>'Disconnected Successfully'],200);
    }


}
