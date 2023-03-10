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
    public function check_instrcutor(Request $request)
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

    public function logout(){
        $accessToken = request()->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);
        if(!$token){
            return response()->json([
                'error'=>true,
                'message'=>'Unknown Error!'
            ],422);
        }
        $user=$token->tokenable_type::find($token->tokenable_id);
        $revoke=$user->tokens()->delete();
        if(!$revoke){
            return response()->json([
                'error'=>true,
                'message'=>'Unknown Error!'
            ],422);
        }
        activity()->causedBy($user)->performedOn($user)->event('logout')
                  ->useLog('logout')
                  ->log('Logout, User logout from system');
        activity()->causedBy($user)->performedOn($user)->event('logout')->useLog('location')
                  ->withProperties(['latitude'=>request()->latitude,'longitude'=>request()->longitude,'device_id' => request()->device_id])
                  ->log('Logout, User logout from system');

        return response()->json([
            'success'=>true,
            'message'=>'Logout successfully'
        ]);
    }
}
