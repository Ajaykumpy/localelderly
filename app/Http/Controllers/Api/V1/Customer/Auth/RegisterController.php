<?php

namespace App\Http\Controllers\Api\V1\Customer\Auth;

use App\Http\Controllers\Controller;

use App\Models\OtpVerificationCode;
use App\Models\UserDevices;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * User signup checking from api
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function check_signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_phone' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        //check if mobile no or email
        if(is_numeric($request->email_phone)){
            $user = User::where('mobile',$request->email_phone)->where('deleted',0)->where('ban',0)->first();
            if(!$user){
                return response()->json([
                    'error'=>true,
                    'message'=>'No user found!'
                ],422);
            }
        }else{
            //check if mobile no or email
            $user = User::where('email',$request->email_phone)->where('deleted',0)->where('ban',0)->first();
            if(!$user){
                return response()->json([
                    'error'=>true,
                    'message'=>'No user found!'
                ],422);
            }
        }
        return response()->json([
            'success' => true,
            'message'=>'User found!'
            // 'user'  => $user,
        ],200);
    }


    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile' => 'required|min:10|max:10',
            'email' => 'required|email|unique:users',
            "country_code"=>'required',
            "password" =>'required|min:6',
        ]);
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $user = User::where('mobile',$request->mobile)->where('deleted',0)->where('ban',0)->first();
        if($user){
            return response()->json([
                'error'=>true,
                'message'=>'User exists'
            ],422);
        }
        $user = User::create([
            'name' =>$request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'country_code' => $request->country_code,
            "password" => Hash::make($request->password),
            'status'=> 0
        ]);
        if(!$user){
            return response()->json(['error'=>true,'message'=>'Something went wrong!'], 422);
        }
        \Auth::login($user);
        $user->token =  $user->createToken('api')->plainTextToken;
        $device=UserDevices::create([
            'user_id' =>$user->id,
            'device_id' =>$request->device_id??Null,
            'device_type' => $request->device_type??Null,
        ]);
       // send verification otp
        if($request->has('mobile') && !empty($request->mobile)){
        //     $otp = random_int(100000, 999999);
        //     $user_otp =new  OtpVerificationCode;
        //     $user_otp->mobile=$request->mobile;
        //     $user_otp->otp=$otp;
        //     $user_otp->status='pending';
        //     $user_otp->save();
        //     $send_otp=send_otp($request->mobile,$otp);
        //     $user_otp->status='sent';
        //     $user_otp->save();
        }
        //to do email verification
        // dd($user);
        return response()->json([
            'success' => true,
            'message' => 'Registeration successfully. Please verify mobile and email',
            'data' => $user,
        ], 200);

    }
    public function mobile_verification(Request $request){
        $this->validate($request,[
            'mobile'=>'required|min:10|max:10',
            'otp'=>'required'
        ]);
        $otp_verification = OtpVerificationCode::where('mobile' ,$request->mobile)->where('otp',$request->otp)->first();
        if(!$otp_verification){
            return response()->json([
                'success' => true,
                'message' => 'Mobile number verification failed!',
            ], 422);
        }
        $doctor=User::where('mobile',$request->mobile)->update([
            'mobile_verified_at'=>now()
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Mobile number verified successfully.',
        ], 200);
    }
}
