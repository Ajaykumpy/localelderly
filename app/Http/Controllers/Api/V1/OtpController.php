<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\OtpVerificationCode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Carbon;

class OtpController extends Controller
{
    public function generate_otp(Request $request){
        $request->validate([
          'mobile' => 'required|min:10|max:10',
        ]);

        $mobile = ['9867031141','9699660904','9325256329','7304859164','9892209756','7021575229','7021640778'];
        foreach($mobile as $no){
          if($no ==  $request->mobile){
              $otp = "123456";
              $old_otps=DB::table('otp_verification_code')->where('mobile',$request->mobile)
                          ->whereStatus('checking')
                          ->update(['expired_at'=>now(),'status'=>'expired']);
              //genearte new one
              $user_otp = DB::insert('insert into otp_verification_code(mobile, otp, status,expired_at,created_at,updated_at) values (?, ?, ?, ?, ?, ?)', [$request->mobile, $otp, 'Checking',  now()->addMinutes(5), carbon::now(),carbon::now()]);
              $err = False;
              if($err) {
                return response()->json(['error'=>true,'message'=>'Something went wrong'],422);
              } else {
                return response()->json(['success'=>true,'mobile'=> $request->mobile,'otp'=>$otp],200);
              }  
          }
        }//this will be for only selected mobile no.
        

          $otp = random_int(100000, 999999);
          //makes other expired
            $old_otps=DB::table('otp_verification_code')->where('mobile',$request->mobile)
                              ->whereStatus('checking')
                              ->update(['expired_at'=>now(),'status'=>'expired']);
          //genearte new one
          $user_otp = DB::insert('insert into otp_verification_code(mobile, otp, status,expired_at,created_at,updated_at) values (?, ?, ?, ?, ?, ?)', [$request->mobile, $otp, 'Checking',  now()->addMinutes(5), carbon::now(),carbon::now()]);
        
          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.authkey.io/request?authkey=abd19922e8887923&mobile='.$request->mobile.'&country_code=91&sid=6560&otp='.$otp.'&time='.'%20mins.',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
          ));
          $response = curl_exec($curl);
          $err = curl_error($curl);
          curl_close($curl);
        if($err) {
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
      $verify_otp=OtpVerificationCode::where('mobile',$request->mobile)->whereStatus('Checking')->where('otp',$request->otp)->latest()->first();
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
}