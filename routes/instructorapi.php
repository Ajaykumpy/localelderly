<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Instructor\LoginController;
use App\Http\Controllers\Api\V1\MeetingRequestController;
use App\Http\Controllers\Api\V1\Instructor\PrivacyPolicyController;
use App\Http\Controllers\Admin\SpecialistController;
use App\Http\Controllers\Api\V1\Instructor\DoctorStatusController;
use App\Http\Controllers\Api\V1\Instructor\DoctorFeedbackController;
use App\Http\Controllers\Api\V1\Instructor\DoctorCallLogController;
use App\Http\Controllers\Api\V1\Instructor\AppVersionController;
use App\Http\Controllers\Api\V1\Instructor\OtpController;
use App\Http\Controllers\Api\V1\Instructor\TermsandconditionController;
use App\Http\Controllers\Api\V1\Account\BankController;
use App\Http\Controllers\Api\V1\Instructor\PrescriptionController;
use App\Http\Middleware\DoctorCheckStatus;
use App\Http\Controllers\Api\V1\Patient\EmergencyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Patient and doctor login
Route::post('register',[App\Http\Controllers\Api\V1\Instructor\Auth\RegisterController::class,'register']);
Route::post('mobile-verification',[App\Http\Controllers\Api\V1\Instructor\Auth\RegisterController::class,'mobile_verification']);
Route::post('check/doctor',[LoginController::class,'check_doctor']);
Route::post('login',[LoginController::class,'authenticate']);
Route::any('appversion',[App\Http\Controllers\Api\V1\Instructor\AppVersionController::class,'show']);//logout

// App Version
Route::get('doctor_condition',[TermsandconditionController::class,'get_doctermandconditions']);

//Terms and Condition
// Route::get('terms-and-condition',[TermsandconditionController::class,'get_termandcondition']);
Route::get('doctor_condition',[TermsandconditionController::class,'get_doctermandconditions']);
//Privacy Policy
Route::get('privacy-policy',[PrivacyPolicyController::class,'get_privacypolicy']);
// Otp generate and Verification
Route::post('otp/generate',[OtpController::class,'generate_otp']);
Route::any('otp/verification',[OtpController::class,'otpVerification']);
Route::post('education',[LoginController::class,'store_doctor_education']);
Route::get('education/details',[LoginController::class,'get_doctor_education']);
Route::get('speciality',[SpecialistController::class,'getSpeciality']);

Route::middleware(['auth:sanctum',DoctorCheckStatus::class])->group( function () {
  Route::prefix("V1")->group(function(){

    Route::post('forgot/password',[LoginController::class,'forgotPassword']);

    Route::get('speciality',[SpecialistController::class,'getSpeciality']);
    Route::get('profile',[LoginController::class,'profiles']);

    Route::get('profile-status',[\App\Http\Controllers\Api\V1\Instructor\Account\DoctorProfileController::class,'profile_status']);
    Route::post('profile/update',[LoginController::class,'store_doctor_education']);
    Route::any('account/delete',[\App\Http\Controllers\Api\V1\Instructor\Account\DoctorProfileController::class,'account_delete']);
    //Doctor Profile
    Route::post('profile-update',[\App\Http\Controllers\Api\V1\Instructor\Account\DoctorProfileController::class,'store']);

    Route::any('status/online',[DoctorStatusController::class,'online']);
    Route::any('status/offline',[DoctorStatusController::class,'offline']);
    Route::any('check/status',[DoctorStatusController::class,'check_status']);
	Route::any('check/available',[DoctorStatusController::class,'check_available']);
    Route::post('doctor/feedback',[DoctorFeedbackController::class,'doctorfeedback']);
    Route::get('doctor/feedbacklist',[DoctorFeedbackController::class,'get_feedback']);

    // Meeting Request
    Route::get('getrequest',[MeetingRequestController::class,'getpatientrequest']);
    //prescription
    Route::post('/prescription/pdf',[\App\Http\Controllers\Api\V1\Instructor\PrescriptionController::class,'download_pdf'])->name('api.v1.doctor.prescription.pdf');
    Route::resource('prescription',\App\Http\Controllers\Api\V1\Instructor\PrescriptionController::class)->names('api.v1.prescription');
    Route::post('pdf/prescription',[PrescriptionController::class,'pdf_download']);
    Route::post('pdf/last/prescription',[PrescriptionController::class,'last_precription_pdf']);

    //emergency call request
	Route::post('call/request/cancel/call',[\App\Http\Controllers\Api\V1\Instructor\EmergencyController::class,'call_request_cancel_call']);
	Route::post('call/request/complete/call',[\App\Http\Controllers\Api\V1\Instructor\EmergencyController::class,'call_request_complete']);
    Route::resource('callrequest',\App\Http\Controllers\Api\V1\Instructor\EmergencyController::class);
    Route::post('patient/info',[\App\Http\Controllers\Api\V1\Instructor\PatientController::class,'index']);

    //Doctor Bank Details
    Route::post('bank-account',[BankController::class,'create']);
    Route::put('bank/update',[BankController::class,'update']);
    Route::get('bank-details',[BankController::class,'show']);

    //call logs
    Route::get('call/logs',[DoctorCallLogController::class,'store']);
    Route::get('calllogs/list',[DoctorCallLogController::class,'index']);
	Route::get('calllog/list/{id}',[DoctorCallLogController::class,'show']);

    Route::any('call/request/update',[EmergencyController::class,'update_call_request']);//use to update record for who accepted patient call and remove unwanted data
    //Wallet
    Route::resource('wallet',\App\Http\Controllers\Api\V1\Instructor\Account\WalletController::class)->only(['index','store']);

  });//prefix end
});//middleware end
