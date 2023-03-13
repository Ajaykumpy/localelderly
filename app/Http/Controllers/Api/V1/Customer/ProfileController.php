<?php

namespace App\Http\Controllers\Api\V1\Patient;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use App\Models\HealthRecord;
use App\Models\UserHealthRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserEmergencyContact;

class ProfileController extends Controller
{

     /**
    * Emergency contact list
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function emergency_contact_list(){
        // activity()->causedBy("App\Models\UserEmergencyContact")->performedOn("App\Models\UserEmergencyContact")->event('emergency-contact')
        // ->useLog('emergency-contact')
        // ->log('Look, User Go in emergency-contact');
        $contact = UserEmergencyContact::select('id','name','mobile')->where('user_id',auth()->user()->id)->get();

        if(!$contact){
            return response()->json(['error'=>true,'message'=>'Something went wrong'],422);
        }
        // dd($contact);

        return response()->json(['success'=>true,'contact'=>$contact],200);
    }

    /**
    * Upload Emergency contact of patient
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function emergency_contact_store(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(),422);
        }
        $mobile = UserEmergencyContact::where('user_id',auth()->user()->id)->where('mobile',$request->mobile)->count();
        // 1. Just to check, customer cannot add same mobile number twice.
        // 2. But two different customer can add same mobile number.
        if($mobile > 0){
            return response()->json(['error'=>true, 'message'=>'Mobile no. Exists'],422);
        }
        $contact = new UserEmergencyContact;
        $contact->user_id   =  auth()->user()->id;
        $contact->name      =  $request->name;
        $contact->mobile    =  $request->mobile;
        $contact->created_by    =  auth()->user()->id;
        $contact->updated_by    =  NULL;
        $contact->save();
        if(!$contact){
            return response()->json(['error'=>true,'message'=>'Something went wrong']);
        }
        return response()->json(['success'=>true,],200);
    }

    /**
    * Update Emergency contact of patient
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function emergency_contact_update(Request $request,$id){
        $validator=Validator::make($request->all(),[
            'name'=>'required',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(),422);
        }
        $contact = UserEmergencyContact::find($id);
        $contact->name      =  $request->name;
        $contact->mobile    =  $request->mobile;
        $contact->updated_by    =  auth()->user()->id;
        $contact->save();
        if(!$contact){
            return response()->json(['error'=>true,'message'=>'Something went wrong']);
        }
        return response()->json(['success'=>true,],200);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy_emergency_contact($id)
    {
      try {
            $contact = UserEmergencyContact::find($id);
            if($contact){
                $contact->mobile = $contact->mobile.'-del';
                $contact->save();
                $contact = UserEmergencyContact::destroy($id);
                return response()->json(['success'=>true,'message'=>'Delete Successfully'],200);
            }
            return response()->json(['error'=>true,'message'=>'No data'],500);
        } catch(\Illuminate\Database\QueryException $e) {
            if($e->getCode() == 23000)
            {
              return response()->json(['error'=>true,'something went wrong'],500);
            }
            return response()->json(['error'=>true,'something went wrong'],500);
        }
    }

}
