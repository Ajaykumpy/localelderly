<?php

namespace App\Http\Controllers\Api\V1\Customer\Account;

use App\Http\Controllers\Controller;
use App\Models\PatientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\UserDevices;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Helpers\UploadHandler;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Storage;

class ProfileController extends Controller
{



   /**
   * User register from app
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */


     /**
    * User login
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */

     /**
    * User Profile Update
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function update_profile(Request $request){
        $user=User::find(auth()->user()->id);

        if($request->has('name') && !empty($request->name)){
            $user->name=$request->name??'';
        }
        if($request->has('email') && !empty($request->email)){
            $user->email=$request->email;
        }
        if($request->has('country_code') && !empty($request->country_code)){
            $user->country_code=$request->country_code;
        }
        if($request->has('mobile') && !empty($request->mobile)){
            $user->mobile=$request->mobile;
        }
        if($request->has('gender') && !empty($request->gender)){
            $user->gender=$request->gender;
        }
        if($request->has('dob') && !empty($request->dob)){
            $user->dob=$request->dob;//\Carbon\Carbon::parse($request->dob)->format('Y-m-d');
        }
        if($request->has('height') && !empty($request->height)){
            $user->height=$request->height;
        }
        if($request->has('weight') && !empty($request->weight)){
            $user->weight=$request->weight;
        }
        if($request->has('physical_activity_level') && !empty($request->physical_activity_level)){
            $user->physical_activity_level=$request->physical_activity_level;
        }
        if($request->has('medical_conditions') && !empty($request->medical_conditions)){
            $user->medical_conditions=$request->medical_conditions;
        }
        if($request->has('allergies') && !empty($request->allergies)){
            $user->allergies=$request->allergies;
        }
        if($request->has('diet_preferences') && !empty($request->diet_preferences)){
            $user->diet_preferences=$request->diet_preferences;
        if($request->has('goal') && !empty($request->diet_preferences)){
            $user->goal=$request->goal;
        }
        }
        // if($request->hasFile('image')){
        //     $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/patient/image/','upload_url'=>asset('uploads/patient/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|webp)$/i',]);
        //     $user->image=$upload->get_response()['image'][0]->url;
        // }
        $user->save();
        if (!$user) {
            return response()->json(['error'=>true,'message'=>'No Contact Found'],422);
        }
          return response()->json(['success'=>true,'message'=>'profile updated successfully','data'=>$user],200);
    }
  

      /**
    * User Profile Store
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */

    public function store_user_profile(Request  $request){

        //Request is valid, create new user
        $user =User::find(auth()->user()->id);
        $user->dob=$request->dob??"NA";
        $user->height=$request->height??"NA";
        $user->weight=$request->weight??"NA";
        $user->age=$request->age??"NA";
        $user->gender=$request->gender??"NA";
        $user->physical_activity_level=$request->physical_activity_level??"NA";
        $user->medical_conditions=$request->medical_conditions??"NA";
        $user->allergies=$request->allergies??"NA";
        $user->diet_preferences=$request->diet_preferences??"NA";
        $user->goal=$request->goal??"NA";
     
        $user->save();
        if (!$user) {
            return response()->json(['error'=>true,'message'=>'No Contact Found'],422);
        }
        return response()->json([
            'success'=>true,
            'message'=> 'profile Saved successfully',
            'data'=>$user
        ]);

    }

    /**
    * User get profile info
    *.
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
     public function profile_info()
     {
        //dd(auth()->id());
        $user  = User::find(auth()->id());
        // $user->profile=PatientProfile::whereUserId(auth()->id())->first();
        //dd($user);
        // activity()->causedBy($user)->performedOn($user)->event('patient-profile')
        // ->useLog('patient-profile')
        // ->log('Look, User logged something');
        return response()->json($user);

    }

     /**
    * User  profile Delete
    *.
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */

    public function account_delete(Request $request){
        //use softdelete
        $user=auth()->user();
        $user->status = 0;
        $user->ban = 1;
        $user->deleted = 1;
        // $user->mobile = $user->mobile."-del";
        $user->email = $user->email."-del";
        $user->save();
        $user->name = $user->name.'del'.
        //need to record lat lng while deletimng user
        activity()->causedBy($user)->performedOn($user)->event('account')->useLog('delete')
        ->withProperties(['user_name'=> $user->name, 'user_email'=> $user->email,'user_mobile'=> $user->mobile,
                          'latitude'=>$request->latitude??"NA",'longitude'=>$request->longitude??"NA"])
        ->log('User deleted his/her account');
        // $user->delete();
        if(!$user){
            return response()->json([
                'error'=>true,
                'message'=>'Unknown Error!'
            ],422);
        }
        return response()->json([
            'success'=>true,
            'message'=>'Account deleted successfully.'
        ],422);
    }
}
