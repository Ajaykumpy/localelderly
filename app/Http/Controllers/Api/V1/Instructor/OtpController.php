<?php

namespace App\Http\Controllers\Api\V1\Instructor;

use App\Http\Controllers\Controller;
use App\Models\OtpVerificationCode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Carbon;

class OtpController extends Controller
{
    public function generate_otp(Request $request){

       // dd($request->all());
       $request->validate([
			//'mobile' => 'required|digits:10|numeric',
		]);
		$user=\App\Models\Doctor::where('mobile',$request->mobile)->latest()->first();
		if(!$user){
			return response()->json(['error'=>true,'message'=>'This mobile number not registerd with us. Please signup'],422);
		}
		$otp = random_int(100000, 999999);
		// $otp= "123456";
		// dd($otp);
		$old_otps=DB::table('otp_verification_code')->where('mobile',$request->mobile)->where('expired_at','>=',now())->update(['expired_at'=>now()]);
		$user_otp = DB::insert('insert into otp_verification_code(mobile, otp, status,expired_at,created_at,updated_at) values (?, ?, ?, ?, ?, ?)', [$request->mobile, $otp, 'Checking', now()->addMinutes(5), carbon::now(),carbon::now()]);
	   // dd( 'https://api.authkey.io/request?authkey=abd19922e8887923&mobile='.$request->mobile.'&country_code=91&sid=6560&otp='.$otp.'&time='.'%20mins');
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.authkey.io/request?authkey=abd19922e8887923&mobile='.$request->mobile.'&country_code=91&sid=6560&otp='.$otp.'&time='.'%20mins',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		));
		// dd();
		$response = curl_exec($curl);
		// dd($response);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  return response()->json(['error'=>true,'message'=>'Something went wrong'],422);
		} else {
		  return response()->json(['success'=>true,'mobile'=> $request->mobile,'otp'=>$otp],200);
		}

    }

    public function otpVerification(Request $request){
      $this->validate($request,[
        'mobile'=>'required',
        'otp'=>'required'
      ]);
      $verify_otp=OtpVerificationCode::where('mobile',$request->mobile)->where('otp',$request->otp)->latest()->first();
        if(!$verify_otp){
            return response()->json([
                'error'=>true,
                'message'=>'No OTP found!'
            ],422);
        }
        if($verify_otp->expired_at && $verify_otp->expired_at<=now()){
            return response()->json([
                'error'=>true,
                'message'=>'OTP Expired! Please regenerate OTP'
            ],422);
        }
        //update otp status
        $verify_otp->status='verified';
        $verify_otp->expired_at=now();
        $verify_otp->save();

        return response()->json([
          'success' => true,
          'message'  => 'OTP Verification Successful',
      ]);
    }
    public function old_otpVerification(Request $request){

    // dd($request->mobile);

        $otpverification = OtpVerificationCode::where('mobile' ,$request->mobile)->where('otp',$request->otp)->first();
        // dd($otpverification);

        if(!$otpverification){
            return response()->json(['message' => 'Invalide Otp',],422);
          }
        //update otp status
        $otpverification->status='verified';
        $otpverification->expired_at=now();
        $otpverification->save();

          return response()->json([
            'success' => true,
            'message'  => 'Otp Verification Success Full',
        ]);

    }



}
