<?php

namespace App\Http\Controllers\Api\V1\Patient;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\PatientCallRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use DB;
use App\Models\CallLog;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments=PatientCallRequest::with('doctor:id,name')->where('user_id',auth()->id())
                            ->select('id as appointment_id','date','start_time','start_end','doctor_id','comment','symptom_id','status')
                            ->when('filter',function($q){
                                //to do
                                $q->orderBy('id','desc');
                            });
        return datatables()->of($appointments)->make(true);
    }

    /**
     * Display appointment list for app.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $appointments=PatientCallRequest::where('user_id',auth()->user()->id)
                            ->join('doctors','patient_call_requests.doctor_id', '=','doctors.id')
                            ->select('patient_call_requests.id','patient_call_requests.status','patient_call_requests.date','patient_call_requests.start_time','patient_call_requests.start_end','patient_call_requests.comment'
                            ,'doctors.name as doctor_name','doctors.id as doctor_id')
                            ->with(['doctor:id,name','doctor.specialist:name'])
                            ->get();
        if($appointments->count()>0){
            $appointments=$appointments->map(function($items){
                $items->specialist=\App\Models\Doctor::find($items->doctor_id)->specialist->name??'';
                unset($items->doctor);
                return $items;
            });
        }
        if(!$appointments->count() > 0){
            return response()->json(['error'=>true, 'list'=>'No Appointment Found'],422);
        }
        return response()->json(['success'=>true, 'list'=>$appointments],200);
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
    * Create time Slots
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function call_request_time_slots()
   {
     $date=request()->date??today();
     $slot_start_time = DB::table('settings')->where('key','slot_start_time')->first();
     $slot_end_time = DB::table('settings')->where('key','slot_end_time')->first();
     $intervals = DB::table('settings')->where('key','slot_intervals')->first();
     $start = new DateTime($slot_start_time->value);
     $end = new DateTime($slot_end_time->value);
     $startTime = $start->format('H:i');
     $endTime = $end->format('H:i');
     $limit=6;//limit on entries for slot
     $i=0;
     $time = [];
     $interval = $intervals->value;
     while(strtotime($startTime) <= strtotime($endTime)){
         $start = $startTime;
         $end = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));
         $startTime = date('H:i',strtotime('+'.$interval.' minutes',strtotime($startTime)));

         if(strtotime($startTime) <= strtotime($endTime)){
           $slots = DB::table('patient_call_requests')->where('date',$date)->where('start_time',$start)
                                ->where('start_end',$end)
                                // ->where('status','!=',3)
                                ->count();
            if($slots < 6){// to do issue
               $time[$i]['slot_start_time'] = $start;
               $time[$i]['slot_end_time'] = $end;
               $time[$i]['session'] = 'Ongoing';
            }else{
               $time[$i]['slot_start_time'] = $start;//date('H:i A',strtotime($start));
               $time[$i]['slot_end_time'] =  $end;//date('H:i A',strtotime($end));
               $time[$i]['session'] = 'Booked';
            }
            //prevent user to book slot for same date and time
			$check_appointment_slot=PatientCallRequest::where('user_id',auth()->id())->where('date',date('Y-m-d',strtotime(str_replace('/', '-', $date))))
                                    ->where('start_time',date('h:i A', strtotime($time[$i]['slot_start_time'])))->where('start_end',date('h:i A', strtotime($time[$i]['slot_end_time'])))->count();
			if($check_appointment_slot>0){
				$time[$i]['session'] = 'Booked';
			}
         }
         $i++;
     }
     return response()->json([
        'success'=>true,
        'data'=>array_values($time)
     ]);
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'date'=>'required',
            'start_time'=>'required',
            'start_end'=>'required'
        ]);
        //check if data available for given date and time
        $check_appointments=PatientCallRequest::where('date',$request->date)->where('start_time',$request->start_time)->where('start_end',$request->start_end)->count();
        if($check_appointments>=6){
            return response()->json([
                'error'=>true,
                'message'=>'All appointment booked for this time slot'
            ],422);
        }
        //prevent user to book slot for same date and time
        $check_appointment_slot=PatientCallRequest::where('user_id',auth()->id())->where('date',$request->date)
                                    ->where('start_time',$request->start_time)->where('start_end',$request->start_end)->count();

        if($check_appointment_slot){
            return response()->json([
                'error'=>true,
                'message'=>'Apointment already booked for this time slot'
            ],422);
        }
        //book appointment
        $appointment=new PatientCallRequest();
        $appointment->user_id=auth()->id()??0;
        $appointment->date=$request->date;
        $appointment->start_time=$request->start_time;
        $appointment->start_end=$request->start_end;
        $appointment->comment=$request->comment;
        $appointment->add_call_latlng = $request->latitude.','.$request->longitude;
        $appointment->save();
		//add patient disease or symptoms
        if($request->has('symptom_id') && !empty($request->symptom_id)){
            $symptom_ids=explode(',',$request->symptom_id);
            $symptom_ids=collect($symptom_ids)->map(function($item)use($appointment){
                $symptom=\App\Models\Symptoms::find($item);
                return [
                    'patient_call_request_id'=>$appointment->id,
                    'patient_id'=>auth()->id(),
                    'symptom_id'=>$item,
                    'symptom'=>$symptom->name??''
                ];
            })->toArray();
            $symptoms=\App\Models\PatientCallRequestSymptom::insert($symptom_ids);
        }

        activity()->causedBy($appointment)->performedOn($appointment)->event('appointment')
                  ->useLog('appointment')
                  ->withProperties(['user_name'=> auth()->user()->name, 'user_email'=> auth()->user()->email,'user_mobile'=>auth()->user()->mobile])
                  ->log('Look, User booked appointment');

        activity()->causedBy($appointment)->performedOn($appointment)->event('appointment')->useLog('location')
                  ->withProperties(['latitude'=>$request->latitude??NULL,'longitude'=>$request->longitude??NULL])
                  ->log('Look, User booked appointment');
		/*
        here is the code to allot internal doctor automatically
		//get interal doctor list for appointments
        $doctors=Doctor::whereHas('doctor_type',function($q){
            $q->where('type','internal');
        })->get();
        //allot doctor to appointment
        if($doctors){
            $doctors=$doctors->map(function($items)use($request){
                $items->appointment_count=PatientCallRequest::where('doctor_id',$items->id)->where('date',$request->date)->where('start_time',$request->start_time)->where('start_end',$request->start_end)->count();
                return $items;
            });
            if($doctors->count()>0 &&  $doctors->sortBy('appointment_count')->first()->appointment_count<6){
                $appointment->doctor_id=$doctors->sortBy('appointment_count')->first()->id;
                $appointment->save();
            }
        }
		*/
        return response()->json([
            'success'=>true,
            'message'=>'Apointment booked successfully'
        ]);

    }

    /**
     * User can cancel appointment before call started.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function appointment_call_cancel(Request $request)
    {
        //updating record that patient cancel the call before the time of appointment call.
        $appointment  = PatientCallRequest::find($request->appointment_id);
        $appointment->status = 3;//this represent the appointment get cancel
        $appointment->cancel_call_latlng = $request->latitude.','.$request->longitude;
        $appointment->save();
        // activity()->causedBy($appointment)->performedOn($appointment)->event('appointment')->useLog('call cancel')
        //           ->withProperties(['latitude'=>$request->latitude??NULL,'longitude'=>$request->longitude??NULL])
        //           ->log('Look, User cancel appointment call');


        activity()->causedBy($appointment)->performedOn($appointment)->event('call cancel')
                  ->useLog('call cancel')
                  ->withProperties(['user_name'=> auth()->user()->name, 'user_email'=> auth()->user()->email,'user_mobile'=>auth()->user()->mobile])
                  ->log('Look, User cancel appointment call');

        activity()->causedBy($appointment)->performedOn($appointment)->event('call cancel')->useLog('location')
                  ->withProperties(['latitude'=>$request->latitude??NULL,'longitude'=>$request->longitude??NULL])
                  ->log('Look, User cancel appointment call');


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
    public function appointment_call_start(Request $request)
    {
        //updating record that patient accepted the call from doctor.
        $appointment  = PatientCallRequest::find($request->appointment_id);
        $appointment->status = 1;//this represent the call started between doctor and patient
        $appointment->start_call_latlng = $request->latitude.','.$request->longitude;
        $appointment->call_start_at  = Carbon::now();//will record when call started
        $appointment->save();
        $call_log = CallLog::where('call_type',1)->where('meeting_id',$request->meeting_id)->where('call_request_id', $request->appointment_id)->first();
        $call_log->status = 'Connected';
        $call_log->save();//updating calllog status to connected        
        // activity()->causedBy($appointment)->performedOn($appointment)->event('appointment')->useLog('call started')
        //           ->withProperties(['latitude'=>$request->latitude??NULL,'longitude'=>$request->longitude??NULL])
        //           ->log('Look, User started appointment call');


         activity()->causedBy($appointment)->performedOn($appointment)->event('call started')
                  ->useLog('call started')
                  ->withProperties(['user_name'=> auth()->user()->name, 'user_email'=> auth()->user()->email,'user_mobile'=>auth()->user()->mobile])
                  ->log('Look, User started appointment call');

        activity()->causedBy($appointment)->performedOn($appointment)->event('call started')->useLog('location')
                  ->withProperties(['latitude'=>$request->latitude??NULL,'longitude'=>$request->longitude??NULL])
                  ->log('Look, User started appointment call');


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
    public function appointment_call_completed(Request $request)
    {
        dd('stop');
        //updating record that patient accepted the call from doctor.
        $appointment  = PatientCallRequest::find($request->appointment_id);
        $appointment->status = 2;//this represent the call completed between doctor and patient
        $appointment->complete_call_latlng = $request->latitude.','.$request->longitude;
        $appointment->save();
        $call_log = CallLog::where('call_type',1)->where('meeting_id',$request->meeting_id)->where('call_request_id', $request->appointment_id)->first();
        $call_log->status = 'Completed';
        $call_log->save();//updating calllog status to connected
        // activity()->causedBy($appointment)->performedOn($appointment)->event('appointment')->useLog('call completed')
        //           ->withProperties(['latitude'=>$request->latitude,'longitude'=>$request->longitude])
        //           ->log('Look, User completed appointment call');

         activity()->causedBy($appointment)->performedOn($appointment)->event('call completed')
                  ->useLog('call completed')
                  ->withProperties(['user_name'=> auth()->user()->name, 'user_email'=> auth()->user()->email,'user_mobile'=>auth()->user()->mobile])
                  ->log('Look, User completed appointment call');

        activity()->causedBy($appointment)->performedOn($appointment)->event('call completed')->useLog('location')
                  ->withProperties(['latitude'=>$request->latitude??NULL,'longitude'=>$request->longitude??NULL])
                  ->log('Look, User completed appointment call');

                  
        if(!$appointment){
            return response()->json(['error'=>true, 'message'=>'something went wrong'],500);
        }
        return response()->json(['success'=>true, 'message'=>'Successfully'],200);
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
}
