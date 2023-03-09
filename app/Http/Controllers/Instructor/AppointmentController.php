<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\PatientCallRequest;
use Illuminate\Http\Request;
use App\Models\CallLog;
use Carbon\Carbon;
use Corcel\Model\Option;
use Doctrine\DBAL\Driver\Mysqli\Initializer\Options;
use App\Models\DoctorStatus;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $patientrequest=PatientCallRequest::with(['patient','doctor.profile','symptoms'])->when('filter',function($q){
                if(request()->has('date') && request()->date=='today'){
                    $q->whereDate('date','>=',today());
                }
                if(request()->has('date') && request()->date=='yesterday'){
                    $q->whereDate('date','<',today());
                }


            })->where('doctor_id',auth()->id());
            return datatables()->of($patientrequest)->make(true);       
       }
        return view('doctor.appointment.index');
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
        $patientrequest = PatientCallRequest::with('patient','doctor')->find($id);
        return view('doctor.appointment.show',compact('patientrequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patientrequest = PatientCallRequest::find($id);
        return view('doctor.appointment.edit',compact('patientrequest'));
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
        if($request->has('type') && $request->type=="status" && !empty($request->status)){
			$patientrequest=PatientCallRequest::find($id);
			$patientrequest->status=$request->status;
            $patientrequest->save();
			return response()->json([
                    'success'=>true,
                    'message'=>'Status updated successfully',
                ]);
		}
        $patientrequest=PatientCallRequest::find($id);
        $patientrequest->doctor_id=$request->doctor_id;
       
        if(!$patientrequest){
            return redirect()->back()->with('error', 'Something went wrong');
        }
        return redirect()->route('doctor.appoinment.index')->with('success', 'Saved Successfully');
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

    public function video_call(Request $request, $id){

        if($request->ajax()){
            $patientrequest = PatientCallRequest::find($id);
            if($request->has('type') && $request->type=='notification'){
                $data=[
                    "type"=>"call","meeting_id"=>$request->meeting_id,
                    "patient_id"=>$patientrequest->patient->id,
                    "patient_name"=>$patientrequest->patient->name,
                    "mobile"=>$patientrequest->patient->mobile??'',"email"=>$patientrequest->patient->email??''
                ];
                $notification=custom_notification($patientrequest->patient->device->device_id,'Appointment Call','From Quantum Corphealth',$data);
                $notification_response=json_decode($notification->getContents());
                if($notification_response->success==1){

                }
                return response()->json([
                    'success'=>true,
                    'message'=>'Notification send.',
                    'data'=>$notification_response
                ]);
            }
            //const PrivilegeKeyLogin   = 1; 
            //const PrivilegeKeyPublish = 2; 
            
            //const PrivilegeEnable     = 1;             
            //const PrivilegeDisable    = 0; 
            $appId = env('ZEGO_APP_ID','124535201');
            $userId = $request->userID;
            $secret = env('ZEGO_SERVER_KEY','93661c9588b45226660f653ddac171dc');
            $rtcRoomPayLoad = [
                'room_id' => $request->roomID,
                'privilege' => [     
                    1 => 1,
                    2 => 0,
                ],
                'stream_id_list' => [] 
            ];
            $payload = json_encode($rtcRoomPayLoad);
            $token = \ZEGO\ZegoServerAssistant::generateToken04($appId,$userId,$secret,3600,$payload);
            if( $token->code == \ZEGO\ZegoErrorCodes::success ){
                return response()->json($token->token);
            }
        }

        $patientrequest = PatientCallRequest::find($id);
        return view('doctor.appointment.video-call',compact('patientrequest'));
    }
    //appointment voice call from doctor login
    public function voice_call(Request $request, $id){

        if($request->ajax()){
            $patientrequest = PatientCallRequest::find($id);
            if($request->has('type') && $request->type=='notification'){
                $data=[
                    "type"=>"call","meeting_id"=>$request->meeting_id,
                    "patient_id"=>$patientrequest->patient->id,
                    "patient_name"=>$patientrequest->patient->name,
                    "mobile"=>$patientrequest->patient->mobile??'',"email"=>$patientrequest->patient->email??'',
                    "appointment_id"=>$request->appointment_id
                ];
				$notification=call_custom_notification($patientrequest->patient->device->device_id,'Appointment Call','From Quantum Corphealth',$data);
                $notification_response=json_decode($notification->getContents());
                if($notification_response->success==1){

                }
				//save meeting id
				$patientrequest->meeting_id=$request->meeting_id;
				$patientrequest->save();
                // record call log of doctor.
                $call_log=CallLog::create([
                    'user_id'    => $patientrequest->patient->id??NULL,
                    'doctor_id'  => auth()->user()->id??NULL,
                    'meeting_id' => $request->meeting_id,
                    'call_request_id'  => $request->appointment_id,
                    'date'       =>  Carbon::today(),
                    'call_type'  => 1,
                    'status'       => 'Pending',
                    'time'       =>  Carbon::now()->toTimeString(),
                    'type'       =>  'Doctor',
                    "latitude"   =>  $request->latitude??NULL,
                    "longitude"  =>  $request->longitude??NULL,
                 ]);
				
                return response()->json([
                    'success'=>true,
                    'message'=>'Notification send.',
                    'data'=>$notification_response
                ]);
            }//end of notification
            //const PrivilegeKeyLogin   = 1; 
            //const PrivilegeKeyPublish = 2; 
            
            //const PrivilegeEnable     = 1;             
            //const PrivilegeDisable    = 0; 
            $options = Option::asArray();
            $appId = $options['ZEGO_APP_ID'];//env('ZEGO_APP_ID');
            $userId = $request->userID;
            $secret = $options['ZEGO_SERVER_KEY'];//env('ZEGO_SERVER_KEY');
            $rtcRoomPayLoad = [
                'room_id' => $request->roomID,
                'privilege' => [     
                    1 => 1,
                    2 => 0,
                ],
                'stream_id_list' => [] 
            ];
            $payload = json_encode($rtcRoomPayLoad);

            // dd($appId,$userId,$secret,3600,$payload);
            $token = \ZEGO\ZegoServerAssistant::generateToken04($appId,$userId,$secret,3600,$payload);
            if( $token->code == \ZEGO\ZegoErrorCodes::success ){
                return response()->json($token->token);
            }
        }
        $Status = DoctorStatus::where('date', '=', Carbon::now()->toDateString())
                        ->where('status','Active')
                        ->where('doctor_id',auth()->id())->first(); 
        if(!$Status){
            $Status = 'offline';
        }else{
            $Status = 'Active';
        }
        $options = Option::asArray();
        $patientrequest = PatientCallRequest::with('patient','doctor')->find($id);
        // env('ZEGO_APP_ID','124535201')
        // env('ZEGO_SERVER_KEY','93661c9588b45226660f653ddac171dc')
        return view('doctor.appointment.voice-call',compact('patientrequest','options','Status'));
    }



    /**
     * Update data that voice call get connected between doctor and patient .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function appointment_call_end(Request $request)
    {
       //updating record that patient accepted the call from doctor.
        // $appointment  = PatientCallRequest::find($request->appointment_id);
        // $appointment->status = 2;//this represent the call completed between doctor and patient
        // $appointment->complete_call_latlng = $request->latitude.','.$request->longitude;
        // $appointment->call_end_at           = Carbon::now();//will record when call ended
        // $appointment->save();
        // $call_log = CallLog::where('call_type',1)->where('meeting_id',$request->meeting_id)->where('call_request_id', $request->appointment_id)->first();
        // $call_log->status = 'Completed';
        // $call_log->save();//updating calllog status to connected
        // activity()->causedBy($appointment)->performedOn($appointment)->event('appointment')->useLog('call completed')
        //           ->withProperties(['latitude'=>$request->latitude,'longitude'=>$request->longitude])
        //           ->log('Look, User completed appointment call');
        // if(!$appointment){
        //     return response()->json(['error'=>true, 'message'=>'something went wrong'],500);
        // }
        // return response()->json(['success'=>true, 'message'=>'Successfully'],200);
    }

    /**
     * Update data that voice call get connected between doctor and patient .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function appointment_call_completed(Request $request)
    {
      //updating record that patient accepted the call from doctor.
        $appointment  = PatientCallRequest::find($request->appointment_id);
        $appointment->status = 2;//this represent the call completed between doctor and patient
        $appointment->complete_call_latlng = $request->latitude.','.$request->longitude;
        $appointment->call_end_at           = Carbon::now();//will record when call ended

        //call log
        $call_log = CallLog::where('call_type',1)->where('meeting_id',$request->meeting_id)->where('call_request_id', $request->appointment_id)->first();
        $call_log->status = 'Completed';
        

        //saving both 
        $appointment->save();
        $call_log->save();//updating calllog status to connected

        activity()->causedBy($appointment)->performedOn($appointment)->event('appointment')->useLog('call completed')
                  ->withProperties(['latitude'=>$request->latitude,'longitude'=>$request->longitude])
                  ->log('Look, User completed appointment call');
        if(!$appointment){
            return response()->json(['error'=>true, 'message'=>'something went wrong'],500);
        }
        return response()->json(['success'=>true, 'message'=>'Successfully'],200);
    }

    /**
     * Update data that voice call get connected between doctor and patient .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function appointment_not_connected(Request $request)
    {
      //updating record that patient accepted the call from doctor.
        $appointment  = PatientCallRequest::find($request->appointment_id);
        $appointment->status = 4;//this represent the call didn't connected between doctor and patient
        $appointment->complete_call_latlng = NULL;//$request->latitude.','.$request->longitude;
        $appointment->call_end_at           = NULL;//Carbon::now();//will record when call ended
        $appointment->save();  
        activity()->causedBy($appointment)->performedOn($appointment)->event("appointment")
                  ->useLog('login');      
        if(!$appointment){
            return response()->json(['error'=>true, 'message'=>'something went wrong'],500);
        }
        return response()->json(['success'=>true, 'message'=>'Successfully'],200);
    }

    



}