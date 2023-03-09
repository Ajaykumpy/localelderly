<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\PatientCallRequestPrescription;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            $prescription=Prescription::with(['patient','doctor.profile','symptom'])->where('created_when','APPOINTMENT')->when('filter',function($q){
                if(request()->has('patient_id') && !empty(request()->patient_id)){
                    //$q->where('patient_id',request()->patient_id);
                }
                $q->where('doctor_id',auth()->id());
            });
            return datatables()->of($prescription)->addColumn('action',function($data){
                return '<div class="actions">
                        <a href="'.route("doctor.prescription.show",$data->prescription_id).'" class="text-black">
							<i class="feather-eye me-1"></i>
                        </a>
						<a target="_blank" href="'.route("doctor.prescription.pdf",$data->prescription_id).'" class="text-black">
							<i class="feather-download me-1"></i>
                        </a>
                        </div>';
            })->make(true);
        }
        return view('doctor.prescription.index');
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
		$this->validate($request,[
			'diagnosis'=>'required'
		]);
        $prescription=new Prescription;
        $prescription->weight=$request->weight??0;
        $prescription->meeting_id=$request->meeting_id??0;
        $prescription->weight_class=$request->weight_unit??"kg";
        $prescription->diagnosis=$request->diagnosis??'';
        $prescription->description=$request->description??'';
        $prescription->date=$request->date??today();//YYYY-MM-DD
        $prescription->patient_id=$request->patient_id;
        $prescription->doctor_id=auth()->id();
        $prescription->created_when='APPOINTMENT'; 
        $prescription->patient_call_request_id= $request->appointment_id;
        $prescription->save();
        if(!$prescription){
            return response()->json([
                'error'=>true,
                'message'=>'Unknown Error!'
            ]);
        }
        //adding in patient_call_request_prescription
        $patient_call_request_prescription=new PatientCallRequestPrescription;
        $patient_call_request_prescription->patient_call_request_id=$request->patient_call_request_id;
        $patient_call_request_prescription->prescription_id=$prescription->prescription_id;
        $patient_call_request_prescription->save();

        if($request->has('symptoms')){
            $request->symptoms=explode(',',$request->symptoms);
            if(is_array($request->symptoms) && count($request->symptoms)>0){
                $symptoms=$prescription->symptom()->createMany(collect($request->symptoms)->map(function($items){return ['symptom'=>trim($items)];}));
            }
            else{
                $symptoms=$prescription->symptom()->create(['symptom'=>$request->symptoms]);
            }
        }
        if($request->has('medicines') && count($request->medicines)>0){
            foreach($request->medicines as $medicine){
                if($medicine['medicine_name']){
                    $prescription_medicine = PrescriptionMedicine::create([
                        "patient_id"=>$prescription->patient_id,
                        "doctor_id"=>$prescription->doctor_id,
                        "prescription_id" =>$prescription->prescription_id,
                        "medicine_name"=>  $medicine['medicine_name'],
                        "quantity"=>  $medicine['quantity']??0,
                        "strength"=>  $medicine['strength']??"",
                        "strength_unit"=>  $medicine['strength_unit']??"",
                        "dosage"=>  $medicine['dosage']??"",
                        "dosage_unit"=>  $medicine['dosage_unit']??"",
                        "duration"=>  $medicine['duration']??"",
                        "duration_unit"=>  $medicine['duration_unit']??"",
                        "preparation"=>  $medicine['preparation']??"",
                        "direction"=>  $medicine['direction']??"",
                        "note"=>  $medicine['note']??""
                    ]);
                }
            }
        }
		//send notification to patient
		// $data=[
        //             "type"=>"notice",
		// 			"meeting_id"=>$prescription->meeting_id,
        //             "patient_id"=>$prescription->patient->id,
        //             "patient_name"=>$prescription->patient->name,
        //             "mobile"=>$prescription->patient->mobile??'',
		// 			"email"=>$prescription->patient->email??''
		// ];
		// $notification=call_custom_notification($prescription->patient->device->device_id,'New Prescription added','From Quantum Corphealth', $data);
		// $notification_response=json_decode($notification->getContents());

        return response()->json([
            'success'=>true,
            'message'=>"Prescription Added successfully."
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prescription=Prescription::findOrFail($id);
        return view('doctor.prescription.show',compact('prescription'));
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

    public function download_pdf(Request $request,$id){
        $prescription=Prescription::findOrFail($id);
        //bmi calculator
        $bmi=0;
        if($prescription->patient){
            $bmi = getBmi($prescription->patient->height??NULL,  $prescription->patient->weight??NULL);
        }   
       
        //return view('admin.prescription.pdf', compact('prescription','bmi'));
        $pdf = \Pdf::loadView('extension.download.prescription', compact('prescription','bmi'));
        return $pdf->download($prescription->patient->name??"".' '.$prescription->prescription_id.'.pdf');
    }

}
