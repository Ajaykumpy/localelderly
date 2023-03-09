<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmergencyCallRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:emergency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Connect offline doctor';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		/*$unattended_call_request=\App\Models\CallRequest::where('doctor_id',null)->whereStatus('pending')
						->whereDate('created_at', today())
						->where('created_at','<=', now()->subSeconds(30))
						->orderBy('id','asc')->first();   
        
        $emergency_doctor=\App\Models\Doctor::whereHas('doctor_type',function($q){
            $q->where('type','emergency');
        })->where('doctors.available',1)
		->join('doctor_devices','doctors.id','=','doctor_devices.doctor_id')
		->get();
		
        if($unattended_call_request){
            if($emergency_doctor->count()>0){
                foreach($emergency_doctor as $doctor){
					$call_request_filter=new \App\Models\CallRequestFilter();
                    $call_request_filter->call_request_id=$unattended_call_request->id;
                    $call_request_filter->doctor_id=$doctor->id;
                    $call_request_filter->status=0;
                    $call_request_filter->notification=0;
                    $call_request_filter->save();
                    $data=[
                        "type"=>"call","meeting_id"=>$unattended_call_request->meeting_id,
                        "patient_id"=>$unattended_call_request->patient_id,
                        "patient_name"=>$unattended_call_request->patient->name,
                        "mobile"=>$unattended_call_request->patient->mobile??'',
						"email"=>$unattended_call_request->patient->email??''
                    ];
                    $notification=custom_notification($doctor->device_id,'Emergency Call','patient request',$data);
                    $notification_response=json_decode($notification->getContents());
                    \Log::info($notification->getContents());
                    if($notification_response->success==1){
                        $call_request_filter->notification=$notification_response->success;
                        $call_request_filter->save();
                    }
                }        
            }
        }*/
        \Log::info('cron working at: '.now());
    }
}
