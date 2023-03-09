<?php

namespace App\Http\Controllers\Api\V1\Instructor\Auth;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\InstructorDevice;
use App\Models\OtpVerificationCode;
use App\Providers\RouteServiceProvider;
use App\Models\User;
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



    public function register(Request $request){
    try{
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile' => 'required|unique:instructors',
            'email' => 'nullable|email|unique:instructors',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $instructor = Instructor::create([
            'name' =>$request->name,
            'email' => $request->email??NULL,
            'mobile' => $request->mobile,
            // 'country_code' => $request->country_code,
            "password" => Hash::make($request->password),
            'status'=> 0
        ]);
        if(!$instructor){
            return response()->json(['error'=>true,'message'=>'Something went wrong!'], 422);
        }
        $device=InstructorDevice::create([
            'instructor_id' =>$instructor->id,
            'device_id' =>$request->device_id??NULL,
        ]);
         // dd($instructor->id);
        // send verification otp and mobile verification
        // if($request->has('mobile') && !empty($request->mobile)){
        //     $otp = random_int(100000, 999999);
        //     $user_otp =new  OtpVerificationCode;
        //     $user_otp->mobile=$request->mobile;
        //     $user_otp->otp=$otp;
        //     $user_otp->status='pending';
		// 	$user_otp->expired_at=now()->addMinutes(5);
        //     $user_otp->save();
        //     $send_otp=send_otp($request->mobile,$otp);
        //     $user_otp->status='checking';
        //     $user_otp->save();
        // }
        return response()->json([
            'success' => true,
            'message' => 'Instructor registered successfully.',
            'data' => $instructor,
        ], 200);
    }catch (\Throwable $th) {
        \Sentry\captureException($exception);
              return response()->json([
              'error'=> true,
              'message'=> 'Something went wrong'
          ]);
      }
    }

    // public function mobile_verification(Request $request){
    //     $this->validate($request,[
    //         'mobile'=>'required',
    //         'otp'=>'required'
    //     ]);
    //     $otp_verification = OtpVerificationCode::where('mobile' ,$request->mobile)->where('otp',$request->otp)->first();
	// 	if($otp_verification->expired_at && $otp_verification->expired_at<=now()){
    //         return response()->json([
    //             'error'=>true,
    //             'message'=>'OTP Expired! Please regenerate OTP'
    //         ],422);
    //     }
    //     if(!$otp_verification){
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Mobile number verification failed!',
    //         ], 422);
    //     }
    //     $doctor=Doctor::where('mobile',$request->mobile)->update([
    //         'mobile_verified_at'=>now()
    //     ]);
    //     $otp = OtpVerificationCode::where('mobile' ,$request->mobile)->where('otp',$request->otp)->update([
    //                                                 'status'=>'Verified'
    //                                                 ]);
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Mobile number verified successfully.',
    //     ], 200);
    // }

}
