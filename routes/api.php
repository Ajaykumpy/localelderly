<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\V1\Videocall\VideoCallController;
use \App\Http\Controllers\Api\V1\Customer\Account\ProfileController;
use App\Http\Controllers\Api\V1\OtpController;
use App\Http\Controllers\Api\V1\AllergyController;
use App\Http\Controllers\Api\V1\Category\CategoryApiController;
use App\Http\Controllers\Api\V1\Category\SubCategoryApiController;

// use App\Http\Controllers\Api\V1\Customer\ProfileController;
// use App\Http\Controllers\Api\V1\Customer\YellowButtonController;
// use App\Http\Controllers\Api\V1\Customer\PatientFeedbackController;
// use App\Http\Controllers\Api\V1\Customer\PatientProfileController;
// use App\Http\Controllers\Api\V1\SubscriptionController;
// use App\Http\Controllers\Admin\SymptomsController;
// use App\Http\Controllers\Admin\TermsandconditionController;
// use App\Http\Controllers\Admin\PrivacyPolicyController;
// use App\Http\Controllers\Api\V1\Customer\Account\UserActivityController;
// use App\Http\Controllers\Api\V1\PackageController;
// use App\Http\Controllers\Api\V1\Customer\EmergencyController;
// use App\Http\Controllers\Admin\HealthRecordController;
// use App\Http\Controllers\Api\V1\MeetingRequestController;
// use App\Http\Controllers\Api\V1\Customer\UserCallLogController;
// use App\Http\Controllers\Api\V1\CallBackController;
// use App\Http\Controllers\Api\V1\Patient\AppVersionController;
use App\Http\Controllers\Api\V1\Customer\Auth\LoginController;
use App\Http\Controllers\Api\V1\Banner\BannerController;
// use App\Http\Controllers\Api\V1\Patient\DoctorProfileController;
 use App\Http\Middleware\CheckStatus;
// use App\Http\Controllers\Api\V1\Patient\Account\PatientBankController;

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

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    return response()->json('done');
  });

  Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});


Route::post('signup',[App\Http\Controllers\Api\V1\Customer\Auth\RegisterController::class,'register']);
Route::post('mobile-verification',[App\Http\Controllers\Api\V1\Customer\Auth\RegisterController::class,'mobile_verification']);
Route::post('check/registration',[App\Http\Controllers\Api\V1\Customer\Auth\RegisterController::class,'check_signUp']);
Route::post('login',[\App\Http\Controllers\Api\V1\Customer\Auth\LoginController::class,'login']);
// Otp generate and Verification
Route::post('otp/generate',[OtpController::class,'generate_otp']);
Route::any('otp/verification',[OtpController::class,'otpVerification']);
Route::post('forgot/password',[LoginController::class,'forgotPassword']);

//Banner
Route::get('banner/list',[BannerController::class,'bannerList']);


//allergy
Route::get('allergy/list',[AllergyController::class,'allergy_List']);

//Category
Route::get('category/list',[CategoryApiController::class,'category_List']);


//SubCategory
Route::get('subcategory/list',[SubCategoryApiController::class,'subCategory_list']);

//
// Route::any('logout',[App\Http\Controllers\Api\V1\Customer\Auth\LoginController::class,'logout']);//logout
// //App Version
// Route::any('appversion',[App\Http\Controllers\Api\V1\Customer\AppVersionController::class,'show']);//logout


// // VideoCall
// Route::post('video/call/token', [VideoCallController::class, 'token']);
// // Subscription
// Route::get('subscription',[SubscriptionController::class,'index']);
// // Symptoms
// Route::post('symptomslist',[SymptomsController::class,'symptoms_list']);
// Route::get('symptomsinfo',[SymptomsController::class,'getsymptoms_list']);

// //Package
// Route::get('package',[PackageController::class,'getpackage']);

// //api for the callback request from thirdparty video streaming app
// Route::post('playback',[CallBackController::class,'callback_stream_created']);

// //Terms and Condition
// Route::get('terms-and-condition',[TermsandconditionController::class,'get_termandcondition']);


// //Privacy Policy
// Route::get('privacy-policy',[PrivacyPolicyController::class,'get_privacypolicy']);

Route::middleware(['auth:sanctum',CheckStatus::class])->group( function () {
  Route::prefix("V1")->group(function(){

    Route::post('profile/update',[ProfileController::class,'update_profile']);
    Route::post('profile/store',[ProfileController::class,'store_user_profile']);
    Route::post('account/delete',[ProfileController::class,'account_delete']);
   


//Package
//     Route::get('package',[PackageController::class,'index']);
// 	Route::get('package/subscriptions',[PackageController::class,'package_subscription']);
// 	Route::post('package',[PackageController::class,'store']);
//     Route::post('package/update',[PackageController::class,'update']);
// 	Route::post('package/renew',[PackageController::class,'renew']);
//     Route::post('package/renew/update',[PackageController::class,'renew_update']);
// 	Route::get('package/status',[\App\Http\Controllers\Api\V1\Customer\Account\PackageController::class,'index']);
//     Route::post('package/payment/fail',[PackageController::class,'payment_failure']);


//     //check activation code. entered by employee of company
//     Route::post('validate/activation/code',[PackageController::class,'validate_activation']);

//     //patient profile
//     Route::get('profile',[AuthController::class,'profile_info']);
//

//     Route::get('videoscreen/profile',[AuthController::class,'videoprofile_info']);


//     Route::get('patient/profile/update',[AuthController::class,'update_profile']);

//     //HealthRecord
//     Route::get('healthrecord',[HealthRecordController::class,'gethealthrecord']);
//     Route::post('healthrecord/store',[ProfileController::class,'health_record']);
//     Route::post('patient/feedback',[PatientFeedbackController::class,'patientfeedback']);

//     // Emergency Contact Map
// 	Route::any('callrequest/unattended',[EmergencyController::class,'emergency_call_notification_unattended']); //Level 2
//     Route::any('callrequest',[EmergencyController::class,'emergency_call_notification']);
//     Route::post('call/request/check/doctor',[EmergencyController::class,'call_request_check_doctor']);
//     Route::post('call/request/cancel/call',[EmergencyController::class,'call_request_cancel_call']);
// 	Route::post('call/request/complete/call',[EmergencyController::class,'call_request_complete']);

//     Route::get('patient/location',[EmergencyController::class,'postlocation']);
//     Route::get('getlocation',[EmergencyController::class,'getpatientlocation']);
//     // Meeting Request
//     Route::post('patient/request',[MeetingRequestController::class,'patientmeetingrequest']);
//
//

//     //Doctor Profile For Patient App
//     Route::get('patient/doctor/profile/{id}',[DoctorProfileController::class,'show']);

//     //call logs
//     Route::get('call/logs',[UserCallLogController::class,'store']);
//     Route::get('calllog/list',[UserCallLogController::class,'index']);
// 	Route::get('calllog/list/{id}',[UserCallLogController::class,'show']);
//     // Patient Bank Details
//     // Route::post('bank-account',[PatientBankController::class,'create']);
//     // Route::put('bank/update/{id}',[PatientBankController::class,'update']);
//     // Route::get('bank-details',[PatientBankController::class,'show']);
//     Route::any('patient/location',[UserActivityController::class,'store']);

//     //emergency contact
//     Route::get('emergency/contact',[ProfileController::class,'emergency_contact_list']);
//     Route::post('store/emergency/contact',[ProfileController::class,'emergency_contact_store']);
//     Route::put('update/emergency/contact/{id}',[ProfileController::class,'emergency_contact_update']);
//     Route::delete('delete/emergency/contact/{id}',[ProfileController::class,'destroy_emergency_contact']);
// 	//prescription
//     Route::post('/prescription/pdf',[\App\Http\Controllers\Api\V1\Customer\PrescriptionController::class,'download_pdf'])->name('api.v1.patient.prescription.pdf');
// 	Route::resource('prescription',\App\Http\Controllers\Api\V1\Customer\PrescriptionController::class)->names('api.vi.patient.prescription');

//   // appointment
//   Route::get('call/request/time/slots',[\App\Http\Controllers\Api\V1\Customer\AppointmentController::class,'call_request_time_slots']);
//   Route::get('appointment/list',[\App\Http\Controllers\Api\V1\Customer\AppointmentController::class,'list']);
//   Route::resource('appointment',\App\Http\Controllers\Api\V1\Customer\AppointmentController::class)->names('api.v1.patient.appointment');
//   Route::post('appointment/call/cancel',[\App\Http\Controllers\Api\V1\Customer\AppointmentController::class,'appointment_call_cancel']);
//   Route::post('appointment/start/call',[\App\Http\Controllers\Api\V1\Customer\AppointmentController::class,'appointment_call_start']);
//   Route::post('appointment/complete/call',[\App\Http\Controllers\Api\V1\Customer\AppointmentController::class,'appointment_call_completed']);
//   Route::post('voicecall/update/status',[\App\Http\Controllers\Api\V1\Customer\AppointmentController::class,'update_voice_call']);


  });//prefix
});//middleware end
