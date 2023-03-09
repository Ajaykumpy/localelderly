<?php

namespace App\Http\Controllers\Api\V1\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Instructor;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDevices;
use Illuminate\Support\Facades\Hash;
use Sentry\Laravel\Integration;

use function GuzzleHttp\Promise\all;

class LoginController extends Controller
{
    /**
    * check doctor data available or not
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function check_doctor(Request $request)
    {
        $doctor = Instructor::where('mobile',$request->mobile)->first();
        if(!$doctor){
            return response()->json(['error'=>true, 'message'=>'Available'],200);
        }
        return response()->json(['success'=>true, 'message'=>'User already registerd'],422);
   }
    /**
   * User authenticate from api
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function authenticate(Request $request)
  {



    //   $validator = Validator::make($request->all(), [
    //       // 'pin' => 'required',
    //       'email_phone' => 'required'
    //   ]);



    //   //Send failed response if request is not valid
    //   if ($validator->fails()) {
    //       return response()->json($validator->messages(), 422);
    //   }

    // if(is_numeric($request->email_phone)){
    //     $Doctor = Instructor::where('mobile',$request->email_phone)->where('deleted',0)->where('ban',0)->first();
    //     if(!$Doctor){
    //         return response()->json([
    //             'error'=>true,
    //             'message'=>'No Doctor found!'
    //         ],422);
    //     }
    // }else{
    //     $Doctor = Instructor::where('email',$request->email_phone)->where('deleted',0)->where('ban',0)->first();
    //     if(!$Doctor){
    //         return response()->json([
    //             'error'=>true,
    //             'message'=>'No Doctor found!'
    //         ],422);
    //     }
    // }

    //     if (!Hash::check($request->password, $Doctor->password)){
    //         return response()->json(['message'=>"Credentials are wrong"],422);
    //     }
    //     $auth = \Auth::login($Doctor);
    //     $Doctor->token =  $Doctor->createToken('api')->plainTextToken;
    //     $device = InstructorDevice::where('instructor_id',auth()->id())->updateOrCreate([
    //         'instructor_id' =>auth()->id(),
    //     ],[
    //         'instructor_id' =>auth()->id(),
    //         'device_id' => $request->device_id,
    //         'device_type' => $request->device_type??'',
    //     ]);

    //   return response()->json([
    //       'success' => true,
    //       'user'  => $Doctor,
    //   ]);





      $validator = Validator::make($request->all(), [
        'email_phone'=>'required',
        "password" =>'required|min:6',
    ]);
    if($validator->fails()) {
        return response()->json($validator->messages(), 422);
    }

    if(is_numeric($request->email_phone)){
        $instructor = Instructor::where('mobile',$request->email_phone)->where('deleted',0)->where('ban',0)->first();
        if(!$instructor){
            return response()->json([
                'error'=>true,
                'message'=>'No user found!'
            ],422);
        }
    }else{
        $instructor = Instructor::where('email',$request->email_phone)->where('deleted',0)->where('ban',0)->first();
        if(!$instructor){
            return response()->json([
                'error'=>true,
                'message'=>'No user found!'
            ],422);
        }
    } 
    if (!Hash::check($request->password, $instructor->password)){
        return response()->json(['message'=>"Credentials are wrong"],422);
    }

        $auth = \Auth::login($instructor);
        $instructor->token =  $instructor->createToken('api')->plainTextToken;
        $device = UserDevices::where('user_id',auth()->user()->id)->updateOrCreate([
            'user_id' =>auth()->user()->id,
        ],[
            'user_id' =>auth()->user()->id,
            'device_id' => $request->device_id??NULL,
            'device_type' => $request->device_type??NULL,
        ]);
        return response()->json([
            'success' => true,
            'message'=>'Login successfully ',
            'instructor'  => $instructor,
            
        ],200);
 
    // } 
   
    // catch (\Throwable $e) {
    //   \Sentry\captureException($exception);
    //         return response()->json([
    //         'error'=> true,
    //         'message'=> 'Something went wrong'
    //     ]);
    // }
}


 /**
    * Instructor Forgot pass word
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */

  public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(),[
            'mobile' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user = Instructor::where('mobile', $request->mobile)->first();
        // $user->password = ;
            if($user){


        $user->password=Hash::make($request->password);
        $user->save();
        if($user){
            return response()->json(['message'=>"password changed successfully"]);
        }

        }else{
            return response()->json(['message'=>"Mobile is not registered"],404);
        }
    }
}