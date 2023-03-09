<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SpecialistController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SymptomsController;
use App\Http\Controllers\Admin\HealthRecordController;
use App\Http\Controllers\Admin\PackageActivationsController;

use App\Http\Controllers\Admin\CallLogController;
use App\Http\Controllers\Admin\CallRequestController;
use App\Http\Controllers\Admin\DoctorFeedbackController;
use App\Http\Controllers\Admin\PatientFeedbackController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\AppoinmentsController;
use App\Http\Controllers\Admin\TermsandconditionController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\EmergencyDoctorController;
use App\Http\Controllers\Admin\AdminAccount\AdminAccountController;



use App\Http\Controllers\MediaController;



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/
Route::middleware('auth:admin')->group( function(){
	Route::get('/',[DashboardController::class,'index'])->name('admin.dashboard');
	//Specialist
	Route::resource('/specialist',SpecialistController::class)->names('admin.specialist');
	Route::delete('specialist/destroy',[SpecialistController::class,'destroy']);
//Admin Account Details

	Route::resource('/edit',AdminAccountController::class)->names('admin.account');

	//Patient
	Route::resource('/patient',PatientController::class)->names('admin.patient');
	Route::delete('patient/destroy',[PatientController::class,'destroy']);
	//Doctor
	Route::resource('/doctor',DoctorController::class)->names('admin.doctor');
	Route::get('approve/doctor/document/{id}',[DoctorController::class,'approve_doctor_document']);
	Route::get('approve/doctor/profile/{id}',[DoctorController::class,'approve_doctor_profile']);
	Route::get('approve/doctor/{id}',[DoctorController::class,'approve_doctor']);
	Route::get('disable/doctor/{id}',[DoctorController::class,'disable_doctor']);

	//Emergency Doctor
	Route::resource('/emergency_doctor',EmergencyDoctorController::class)->names('admin.emergency_doctor');
	
	//Package Activation Code
	Route::resource('/packages',PackageActivationsController::class)->names('admin.package-activation');

	// Doctor Bank Details Controller
	Route::resource('/doctor-bank',DoctorBankDetailsController::class)->names('admin.doctor-bankdetails');

	
	//Package
	Route::resource('/package',PackageController::class)->names('admin.package');
	//Symptoms
	Route::resource('/symptoms',SymptomsController::class)->names('admin.symptoms');
	//Health Record
	Route::resource('/healthrecord',HealthRecordController::class)->names('admin.healthrecord');
	//Call Log Ui
	Route::resource('/calllog',CallLogController::class)->names('admin.call_log');
	// Call Request
	Route::resource('/callrequest',CallRequestController::class)->names('admin.call_request');
	// Call Request
	Route::resource('/question',QuestionController::class)->names('admin.question');
	// Appoinments
	Route::get('/appoinments/{id}/video-call',[AppoinmentsController::class,'video_call'])->name('admin.appoinments.call.video');
	Route::resource('/appoinments',AppoinmentsController::class)->names('admin.appoinments');
	// TermsandconditionController
	Route::resource('/terms-and-conditions',TermsandconditionController::class)->names('admin.terms-and-conditions');
	
	// Doctor FeedBack
	Route::resource('/doctor_feedback',DoctorFeedbackController::class)->names('admin.doctor_feedback');
	// Patient FeedBack
	Route::resource('/patient_feedback',PatientFeedbackController::class)->names('admin.patient_feedback');


	// PrivacyPolicyController
	Route::resource('/privacy-policy',PrivacyPolicyController::class)->names('admin.privacy-policy');

	//General Setting
	Route::get('/settings/localization',[GeneralSettingController::class,'localization'])->name('admin.general_setting.localization');
	Route::get('/settings/email',[GeneralSettingController::class,'email'])->name('admin.general_setting.email');
	Route::get('/settings/appointment',[GeneralSettingController::class,'appointment'])->name('admin.general_setting.appointment');
	Route::get('/settings/app_update',[GeneralSettingController::class,'app_update'])->name('admin.general_setting.app_update');
	Route::resource('/settings',GeneralSettingController::class)->names('admin.general_setting');

	//Media Controller
	Route::post('/file-upload', [MediaController::class, 'store'])->name('media');
	// Pages
	Route::resource('/page',\App\Http\Controllers\Admin\PageController::class)->names('admin.page');

	//update 
	Route::get('/prescription/pdf/{id}',[\App\Http\Controllers\Admin\PrescriptionController::class,'download_pdf'])->name('admin.prescription.pdf'); 
	Route::resource('/prescription',\App\Http\Controllers\Admin\PrescriptionController::class)->names('admin.prescription');
	//Transaction and wallet
	Route::resource('/transaction',\App\Http\Controllers\Admin\TransactionController::class)->names('admin.transaction');

});//middleware end