<?php

namespace App\Http\Controllers\Api\V1\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prescription=Prescription::with(['symptom'])->when('filter',function($q){
            $q->where('doctor_id',auth()->id());
        });
        //dd($prescription->get());
        return datatables()->of($prescription)->make(true);
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
        //$request->request->add(collect($request->json())->toArray());
        //return response()->json([$request->all(), gettype($request->medicines)]);
		//return response()->json($request->medicines);

		$prescription=new Prescription;
        $prescription->weight=$request->weight??0;
	    $prescription->meeting_id=$request->meeting_id??NULL;
        $prescription->weight_class=$request->weight_unit??"kg";
        $prescription->diagnosis=$request->diagnosis??'';
        $prescription->description=$request->description??'';
        $prescription->date=$request->date??today();//YYYY-MM-DD
        $prescription->patient_id=$request->patient_id;
        $prescription->doctor_id=auth()->id();
        $prescription->created_when = "SOS";
        $prescription->save();
        $prescription_id = $prescription->prescription_id;
        // dd($prescription_id);
        if(!$prescription){
            return response()->json([
                'error'=>true,
                'message'=>'Unknown Error!'
            ]);
        }
        if($request->has('symptoms')){
            if(is_array($request->symptoms) && count($request->symptoms)>0){
                $symptoms=$prescription->symptom()->createMany(collect($request->symptoms)->map(function($items){return ['symptom'=>$items];}));
            }
            else{
                $symptoms=$prescription->symptom()->create(['symptom'=>$request->symptoms]);
            }
        }
        if($request->has('vital_sign') && count($request->vital_sign)>0){
            $vital_sign_data=collect($request->vital_sign)->map(function($items){
                return [
                    'name'=>ucwords(str_replace('_',' ',$items['name'])),
                    'key'=>$items['name'],
                    'value'=>$items['value'],
                    'value_class'=>$items['unit']
                ];
            });
            $vital_sign=$prescription->vital_sign()->createMany($vital_sign_data);
        }
        //if($request->has('medicines') && count($request->medicines)>0){
		if($request->has('medicines')){
            if(is_string($request->medicines)){
				$request->medicines = json_decode($request->medicines);
				// $request->medicines = collect($request->medicines)->toArray();
			}

            foreach($request->medicines as $value){
                $pres_medicine = PrescriptionMedicine::create([
                    "patient_id"=>$prescription->patient_id,
                    "doctor_id"=>$prescription->doctor_id,
                    "prescription_id" =>$prescription_id,
                    "medicine_name"=>  $value->drug_name,
                    "quantity"=>  $value->quantity??0,
                    "strength"=>  $value->strength??"",
                    "strength_unit"=>  $value->strength_unit??"",
                    "dosage"=>  $value->dose??"",
                    "dosage_unit"=>  $value->dose_unit??"",
                    "duration"=>  $value->duration??"",
                    "duration_unit"=>  $value->duration_unit??"",
                    "preparation"=>  $value->preparation??"",
                    "direction"=>  $value->direction??"",
                    "note"=>  $value->note??""
                ]);
            }

			// $medicines_data=collect($request->medicines)->map(function($items)use($prescription){

			// 	return [
			// 			"patient_id"=>$prescription->patient_id,
			// 			"doctor_id"=>$prescription->doctor_id,
			// 			"medicine_name"=>$items->drug_name,
			// 			"quantity"=>$items->quantity??0,
			// 			"strength"=>$items->strength??"",
			// 			"strength_unit"=>$items->strength_unit??"",
			// 			"dosage"=>$items->dosage??"",
			// 			"dosage_unit"=>$items->dosage_unit??"",
			// 			"duration"=>$items->duration??"",
			// 			"duration_unit"=>$items->duration_unit??"",
			// 			"preparation"=>$items->preparation??"",
			// 			"direction"=>$items->direction??"",
			// 			"note"=>$items->note??""
			// 		];
			// });
            // $medicines=$prescription->medicine()->createMany($medicines_data);
        }

        //send notification to patient
        // $data=[
        //     "type"=>"notice",
        //     "meeting_id"=>$prescription->meeting_id,
        //     "patient_id"=>$prescription->patient->id,
        //     "patient_name"=>$prescription->patient->name,
        //     "mobile"=>$prescription->patient->mobile??'',
        //     "email"=>$prescription->patient->email??''
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
        $prescription=Prescription::with(['symptom','medicine'])->find($id);
        return response()->json($prescription);
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

	public function download_pdf(Request $request){
        $prescription=Prescription::findOrFail($request->prescription_id);
        $bmi = getBmi($prescription->patient->height??NULL,  $prescription->patient->weight??NULL);
        //return view('admin.prescription.pdf', compact('prescription'));
        $pdf = \Pdf::loadView('extension.download.prescription', compact('prescription','bmi'));
        return $pdf->download($prescription->patient->name.' '.$prescription->prescription_id.'.pdf');
    }

	public function pdf_download(Request $request){

        $prescription =Prescription::where('meeting_id', $request->meeting_id)->first();
        if(!$prescription){
            return response()->json([
                'error'=>true,
                'message'=>'No record found!'
            ],422);
        }
        if(!$prescription->patient){
            return response()->json([
                'error'=>true,
                'message'=>'No record found!'
            ],422);
        }
        // bmi calculator
        if($prescription->patient){
            $bmi = getBmi($prescription->patient->height??NULL,  $prescription->patient->weight??NULL);
        }
        //return view('admin.prescription.pdf', compact('prescription','bmi));
        $pdf = \Pdf::loadView('extension.download.prescription', compact('prescription','bmi'));
        return $pdf->download($prescription->patient->name.' '.$prescription->meeting_id.'.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function last_precription_pdf(Request $request){
        $prescription =Prescription::where('patient_id', $request->user_id)->first();
        if(!$prescription){
			return response()->json([
				'error'=>true,
				'message'=>'No record found!'
			],422);
		}
        // bmi calculator
        $bmi=0;
        if($prescription->patient){
            $bmi = getBmi($prescription->patient->height??NULL,  $prescription->patient->weight??NULL);
        }
        // return view('admin.prescription.pdf', compact('prescription','bmi'));
        $pdf = \Pdf::loadView('extension.download.prescription', compact('prescription','bmi'));
        return $pdf->download($prescription->patient->name.' '.$prescription->meeting_id.'.pdf');
    }
}
