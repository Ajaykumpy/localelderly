<?php

namespace App\Http\Controllers\Api\V1\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Doctor;
use App\Models\DoctorStatus;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Carbon\Carbon;

class DoctorStatusController extends Controller
{
   /**
   * Create Doctor online status
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
    public function online()
    {
        $Status = DoctorStatus::where('date', '=', Carbon::now()->toDateString())
                        ->where('status','Active')
                        ->where('doctor_id',auth()->id())->first();

        if($Status){//check status if already online
            if($Status->status == 'Active'){
                return response()->json(['error'=>true, 'message'=>'Already Online'],422);
            }
        }
        $online = DoctorStatus::create([
                'doctor_id' => auth()->id(),
                'date' =>   Carbon::now()->toDateString(),
                'from_time' => Carbon::now()->toTimeString(),
                // 'latitude'=>request()->latitude??Null,
                // 'longitude'=>request()->longitude??NULl,
                'login_location' => request()->latitude.','.request()->longitude,
                //'position'=> \DB::raw("GeomFromText('POINT(".request()->latitude." ".request()->longitude.")')"), to do
                'status' => 'Active'
            ]);
        if(!$online){
            return response()->json(['error'=>true, 'message'=>'Something went wrong'],422);
        }
        return response()->json(['success'=>true, 'status'=>$online->status],200);
    }
    /**
    * Doctor check online and offline
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function check_status()
    {
        $doctor = DoctorStatus::where('date', '=', Carbon::now()->toDateString())
                        ->where('doctor_id',auth()->id())->latest()->first();
        if(!$doctor){
            return response()->json(['error'=>true, 'message'=>'Please make online'],422);
        }
        return response()->json(['success'=>true, 'status'=>$doctor->status,'date'=>$doctor->date,
            'from_time'=>$doctor->from_time,'to_time'=>$doctor->to_time],200);
    }
    /**
    * Update Doctor offline status
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function offline(){
        //check if doctor is online, if not then return back.
        $Status = DoctorStatus::where('date', '=', Carbon::now()->toDateString())
                                ->where('doctor_id',auth()->id())->where('status','Active')->first();
        if(!$Status){
            return response()->json(['error'=>true, 'message'=>'Please make yourself online'],422);
        }
        $start_time = Carbon::parse($Status->from_time);
        $end_time = Carbon::now()->toTimeString();//record end time
        //calculate minutes from active time and logout time
        $in_minutes = $start_time->diffInMinutes($end_time);
        $hrs = $start_time->diffInHours($end_time);//calculate hours from active time and logout time
        $offline = DoctorStatus::where('date', '=', Carbon::now()->toDateString())
                        ->where('doctor_id',auth()->id())->where('status','Active')->latest()->first();
        $offline->to_time   = Carbon::now()->toTimeString();
        $offline->total_min = $in_minutes;
        $offline->total_hrs = $hrs;
        $offline->status    = 'Offline';
        // $offline->latitude    = request()->latitude??'';
        // $offline->longitude    =request()->longitude??'';
        $offline->logout_location   = request()->latitude.','.request()->longitude;
        //$offline->position    =\DB::raw("GeomFromText('POINT(".request()->latitude." ".request()->longitude.")')"), to do
        $offline->save();
        if(!$offline){
            return response()->json(['error'=>true, 'message'=>'Something went wrong'],422);
        }
        return response()->json(['success'=>true, 'message'=>'Status Offline','status'=>$offline->status],200);
    }
	public function check_available(Request $request){
        $this->validate($request,[
            'available'=>'required'
        ]);
        $doctor=Doctor::findOrFail(auth()->id());
        $doctor->available=(int)$request->available??1;
        $doctor->save();
        return response()->json([
            'success'=>true,
            'message'=>'Doctor availability status updated successfully.'
        ]);
    }

}
