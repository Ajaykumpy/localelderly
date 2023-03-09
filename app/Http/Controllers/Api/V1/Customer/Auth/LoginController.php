<?php

namespace App\Http\Controllers\Api\V1\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpVerificationCode;
use App\Models\User;
use App\Models\UserDevices;
use App\Providers\RouteServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Validator;
use DB;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email_phone'=>'required',
            "password" =>'required|min:6',
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        if(is_numeric($request->email_phone)){
            $user = User::where('mobile',$request->email_phone)->where('deleted',0)->where('ban',0)->first();
            if(!$user){
                return response()->json([
                    'error'=>true,
                    'message'=>'No user found!'
                ],422);
            }
        }else{
            $user = User::where('email',$request->email_phone)->where('deleted',0)->where('ban',0)->first();
            if(!$user){
                return response()->json([
                    'error'=>true,
                    'message'=>'No user found!'
                ],422);
            }
        } 
        if (!Hash::check($request->password, $user->password)){
            return response()->json(['message'=>"Credentials are wrong"],422);
        }

            $auth = \Auth::login($user);
            $user->token =  $user->createToken('api')->plainTextToken;
            $device = UserDevices::where('user_id',auth()->user()->id)->updateOrCreate([
                'user_id' =>auth()->user()->id,
            ],[
                'user_id' =>auth()->user()->id,
                'device_id' => $request->device_id??NULL,
                'device_type' => $request->device_type??NULL,
            ]);
            $login="Login successfully";
     
			if(!$user->physical_activity_level ||  $user->physical_activity_level== 'NA' ||!$user->medical_conditions   || $user->medical_conditions== 'NA' || !$user->allergies ||$user->allergies== 'NA'||
                !$user->diet_preferences||$user->diet_preferences== 'NA' || !$user->height ||$user->height== 'NA' ||!$user->weight ||$user->weight== 'NA' || !$user->dob || $user->dob== 'NA'||!$user->goal || $user->goal== 'NA'){
                $user->profile_status = (int)0;//prompt in app for uploading user data
                return response()->json([
                    'error'=>true,
                    'message'=>$login,
                    'update messsage'=>'Update your  profile',

                    'user'=>$user,
                ],200);

			}else{
				$user->profile_status = (int)1;//user data update successfully, then in app it show please wait for approval screen
			}
            return response()->json([
                'success' => true,
                'message'=>'Login successfully ',
                'user'  => $user,
                
            ],200);

               // activity()->causedBy($user)->performedOn($user)->event('login')
        //           ->useLog('login')
        //           ->log('Look, User logged something');
        // activity()->causedBy($user)->performedOn($user)->event('login')->useLog('location')
        //           ->withProperties(['latitude'=>$request->latitude,'longitude'=>$request->longitude,'device_id' => $request->device_id])
        //           ->log('Look, user logged something');
        //checking if doctor profile is complete or not
    //    if(!$user){
    //         return response()->json([
    //             'error'=>true,
    //             'message'=>'Update your  profile',
    //             'user'=>$user,
    //         ],422);
    //     }else{
    //         return response()->json([
    //             'success' => true,
    //             'message'=>'Login successfully ',
    //             'user'  => $user,
                
    //         ],422);
    //     }
        // return response()->json([
        //     'success' => true,
        //     'user'  => $user,
        //     'message'=>'Update your Profile',
        // ]);
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
    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(),[
            'mobile' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user = User::where('mobile', $request->mobile)->first();
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

