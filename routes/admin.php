<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Category\SubCategoryController;
use App\Http\Controllers\Admin\Banner\BannerController;
use App\Http\Controllers\Admin\Dietitian\DietitianController;
use App\Http\Controllers\Admin\Staff\StaffController;

use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\Customer\CustomerController;
// use App\Http\Controllers\Admin\SpecialistController;
// use App\Http\Controllers\Admin\PatientController;
// use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\Admin\Allergy\AllergyController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PackageActivationsController;
use App\Http\Controllers\Admin\PageController;
// use App\Http\Controllers\Admin\DoctorFeedbackController;
// use App\Http\Controllers\Admin\PatientFeedbackController;
// use App\Http\Controllers\Admin\SymptomsController;
// use App\Http\Controllers\Admin\HealthRecordController;
// use App\Http\Controllers\Admin\CallLogController;
// use App\Http\Controllers\Admin\CallRequestController;
// use App\Http\Controllers\Admin\QuestionController;
// use App\Http\Controllers\Admin\GeneralSettingController;
// use App\Http\Controllers\Admin\AppoinmentsController;
// use App\Http\Controllers\Admin\TermsandconditionController;
// use App\Http\Controllers\Admin\PrivacyPolicyController;
// use App\Http\Controllers\Admin\EmergencyDoctorController;
// use App\Http\Controllers\Admin\InternalDoctorController;
// use App\Http\Controllers\Admin\DoctorBankDetailsController;
use App\Http\Controllers\Admin\AdminAccount\AdminAccountController;
// use App\Http\Controllers\MediaController;
// use App\Http\Controllers\Admin\UserTransactionController;


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
	//program
     Route::group(['prefix'=>'category'],function(){
        Route::get('',[CategoryController::class,'index'])->name('category.index');
        Route::get('/create',[CategoryController::class,'create'])->name('category.create');
        Route::post('/store',[CategoryController::class,'store'])->name('category.store');
        Route::get('/edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
        Route::post('/update/{id}',[CategoryController::class,'update'])->name('category.update');
        Route::delete('/destroy/{id}',[CategoryController::class,'destroy'])->name('admin.category.destroy');
    });


	// 	Route::resource('/doctor',DoctorController::class)->names('admin.doctor');

	//Instructor
	// Route::resource('/instructor',InstructorController::class)->names('admin.instructor');

    Route::get('instructor',[InstructorController::class,'index'])->name('admin.instructor.index');
	// Route::get('instructor/create',[InstructorController::class,'create'])->name('admin.instructor.create');
	Route::post('instructor/store',[InstructorController::class,'store'])->name('admin.instructor.store');
	Route::get('instructor/edit/{id}',[InstructorController::class,'edit'])->name('admin.instructor.edit');
	Route::post('instructor/update/{id}',[InstructorController::class,'update'])->name('admin.instructor.update');
	Route::delete ('instructor/destroy/{id}',[InstructorController::class,'destroy'])->name('admin.instructor.destroy');


   //program
   Route::resource('/program',ProgramController::class)->names('admin.program');

  //customer
  Route::get('customer',[CustomerController::class,'index'])->name('admin.customer.index');
  Route::get('customer/create',[CustomerController::class,'create'])->name('admin.customer.create');
//   Route::post('customer/store',[CustomerController::class,'store'])->name('admin.customer.store');
  Route::get('customer/edit/{id}',[CustomerController::class,'edit'])->name('admin.customer.edit');
  Route::post('customer/update/{id}',[CustomerController::class,'update'])->name('admin.customer.update');
  Route::delete('customer/destroy/{id}',[CustomerController::class,'destroy'])->name('admin.customer.destroy');

	//Allergy
	// Route::resource('/allergy',AllergyController::class)->names('admin.allergy');
	Route::get('allergy',[AllergyController::class,'index'])->name('admin.allergy.index');
	Route::get('allergy/create',[AllergyController::class,'create'])->name('admin.allergy.create');
	Route::post('allergy/store',[AllergyController::class,'store'])->name('admin.allergy.store');
	Route::get('allergy/edit/{id}',[AllergyController::class,'edit'])->name('admin.allergy.edit');
	Route::post('allergy/update/{id}',[AllergyController::class,'update'])->name('admin.allergy.update');
	Route::delete('allergy/destroy/{id}',[AllergyController::class,'destroy'])->name('admin.allergy.destroy');


	// subCatergory
	//  Route::resource('/subcategory',SubCategoryController::class)->names('admin.subcategory');
	Route::post('subcategory/store',[SubCategoryController::class])->name('subcategory.store');
	Route::get('subcategory',[SubCategoryController::class,'index'])->name('admin.subcategory.index');
	Route::get('subcategory/create',[SubCategoryController::class,'create'])->name('admin.subcategory.create');
	Route::post('subcategory/store',[SubCategoryController::class,'store'])->name('admin.subcategory.store');
	Route::get('subcategory/edit/{id}',[SubCategoryController::class,'edit'])->name('admin.subcategory.edit');
	Route::post('subcategory/update/{id}',[SubCategoryController::class,'update'])->name('admin.subcategory.update');
	Route::delete('subcategory/destroy/{id}',[SubCategoryController::class,'destroy'])->name('admin.subcategory.destroy');



	// Banner
	Route::get('banner',[BannerController::class,'index'])->name('admin.banner.index');
	Route::get('banner/create',[BannerController::class,'create'])->name('admin.banner.create');
	Route::post('banner/store',[BannerController::class,'store'])->name('admin.banner.store');
	Route::get('banner/edit/{id}',[BannerController::class,'edit'])->name('admin.banner.edit');
	Route::post('banner/update/{id}',[BannerController::class,'update'])->name('admin.banner.update');
	Route::delete('banner/destroy/{id}',[BannerController::class,'destroy'])->name('admin.banner.destroy');



	// Dietitian
     Route::group(['prefix'=>'dietitian'],function(){
     Route::get('',[DietitianController::class,'index'])->name('admin.dietitian.index');
     Route::get('/create',[DietitianController::class,'create'])->name('admin.dietitian.create');
     Route::post('/store',[DietitianController::class,'store'])->name('admin.dietitian.store');
     Route::get('/edit/{id}',[DietitianController::class,'edit'])->name('admin.dietitian.edit');
     Route::post('/update/{id}',[DietitianController::class,'update'])->name('admin.dietitian.update');
     Route::delete('/destroy/{id}',[DietitianController::class,'destroy'])->name('admin.dietitian.destroy');

    });
     // Staff
     Route::get('staff',[StaffController::class,'index'])->name('admin.staff.index');
     Route::get('/create',[StaffController::class,'create'])->name('admin.staff.create');
     Route::post('/store',[StaffController::class,'store'])->name('admin.staff.store');
     Route::get('/edit/{id}',[StaffController::class,'edit'])->name('admin.staff.edit');
     Route::post('/update/{id}',[StaffController::class,'update'])->name('admin.staff.update');
     Route::delete('/destroy/{id}',[StaffController::class,'destroy'])->name('admin.staff.destroy');


	//Admin Account Details

	Route::resource('/edit',AdminAccountController::class)->names('admin.account');

	//Specialist
	// Route::resource('/specialist',SpecialistController::class)->names('admin.specialist');
	// Route::delete('specialist/destroy',[SpecialistController::class,'destroy']);
	// //Patient
	Route::resource('/patient',PatientController::class)->names('admin.patient');
	// Route::delete('patient/destroy',[PatientController::class,'destroy']);
	// //Doctor
	// Route::resource('/doctor',DoctorController::class)->names('admin.doctor');
	// Route::get('approve/doctor/document/{id}',[DoctorController::class,'approve_doctor_document']);
	// Route::get('approve/doctor/profile/{id}',[DoctorController::class,'approve_doctor_profile']);
	// Route::get('approve/doctor/{id}',[DoctorController::class,'approve_doctor']);
	// Route::get('disable/doctor/{id}',[DoctorController::class,'disable_doctor']);
	// Route::get('switch/doctor/{id}',[DoctorController::class,'switch_to_l2']);
	// Route::get('doctor/login/hours/{id}',[DoctorController::class,'working_hours']);


	// // Doctor FeedBack
	// Route::resource('/doctor_feedback',DoctorFeedbackController::class)->names('admin.doctor_feedback');
	// // Patient FeedBack
	// Route::resource('/patient_feedback',PatientFeedbackController::class)->names('admin.patient_feedback');

    // // Doctor Bank Details Controller
	// Route::resource('/doctor-bank',DoctorBankDetailsController::class)->names('admin.doctor-bankdetails');

	// //Emergency Doctor
	// Route::resource('/emergency_doctor',EmergencyDoctorController::class)->names('admin.emergency_doctor');
    // Route::get('approve/emergency_doctor/document/{id}',[EmergencyDoctorController::class,'approve_doctor_documents']);
	// Route::get('approve/emergency/doctor/profile/{id}',[EmergencyDoctorController::class,'approve_doctor_profile']);
	// Route::get('approve/emergency/doctor/{id}',[EmergencyDoctorController::class,'approve_doctor']);
	// Route::get('disable/emergency/doctor/{id}',[EmergencyDoctorController::class,'disable_doctor']);
	// Route::get('switch/doctor/l1/{id}',[EmergencyDoctorController::class,'switch_to_l1']);

    //Internal Doctor
	// Route::resource('/internal_doctor',InternalDoctorController::class)->names('admin.internal_doctor');
    // Route::get('approve/internal/doctor/document/{id}',[InternalDoctorController::class,'approve_doctor_documents']);
	// Route::get('approve/internal/doctor/profile/{id}',[InternalDoctorController::class,'approve_doctor_profile']);
	// Route::get('approve/internal/doctor/{id}',[InternalDoctorController::class,'approve_doctor']);
	// Route::get('disable/internal/doctor/{id}',[InternalDoctorController::class,'disable_doctor']);
	// Route::get('internal_doctor/login/hours/{id}',[InternalDoctorController::class,'working_hours']);

	//Package
	Route::resource('/package',PackageController::class)->names('admin.package');

    //Package Activation Code
	Route::resource('/packages',PackageActivationsController::class)->names('admin.package-activation');

	// //Route::resource('/destroy',PackageController::class)->names('admin.package.destroy');
	// //Symptoms
	// Route::resource('/symptoms',SymptomsController::class)->names('admin.symptoms');
	// //Health Record
	// Route::resource('/healthrecord',HealthRecordController::class)->names('admin.healthrecord');
	// //Call Log Ui
	// Route::resource('/calllog',CallLogController::class)->names('admin.call_log');
	// // Call Request
	// Route::resource('/callrequest',CallRequestController::class)->names('admin.call_request');
	// // Question
	// Route::resource('/question',QuestionController::class)->names('admin.question');
	// // Appoinments
	// Route::get('/appoinments/{id}/video-call',[AppoinmentsController::class,'video_call'])->name('admin.appointments.call.video');
	// Route::get('/appoinments/{id}/voice-call',[AppoinmentsController::class,'voice_call'])->name('admin.appointments.call.voice');
	// //Route::get('/appoinments/past_appointment',[AppoinmentsController::class,'past_appointment'])->name('admin.appoinments.past_appointment');
	// Route::resource('/appoinments',AppoinmentsController::class)->names('admin.appointments');

	// // TermsandconditionController
	// Route::resource('/terms-and-conditions',TermsandconditionController::class)->names('admin.terms-and-conditions');

	// // PrivacyPolicyController
	// Route::resource('/privacy-policy',PrivacyPolicyController::class)->names('admin.privacy-policy');

	// //General Setting
	Route::get('/settings/localization',[GeneralSettingController::class,'localization'])->name('admin.general_setting.localization');
	// Route::get('/settings/email',[GeneralSettingController::class,'email'])->name('admin.general_setting.email');
	// Route::get('/settings/appointment',[GeneralSettingController::class,'appointment'])->name('admin.general_setting.appointment');
	// Route::get('/settings/app_update',[GeneralSettingController::class,'app_update'])->name('admin.general_setting.app_update');
    // Route::get('/settings/zego_setting',[GeneralSettingController::class,'zego_setting'])->name('admin.general_setting.zego_setting');
    // Route::get('/settings/razor_key',[GeneralSettingController::class,'razor_key'])->name('admin.general_setting.razor_key');

	Route::resource('/settings',GeneralSettingController::class)->names('admin.general_setting');
	// //Media Controller
	// Route::post('/file-upload', [MediaController::class, 'store'])->name('media');
	// Pages
	Route::resource('/page',PageController::class)->names('admin.page');

	// //update
	// Route::get('/prescription/pdf/{id}',[\App\Http\Controllers\Admin\PrescriptionController::class,'download_pdf'])->name('admin.prescription.pdf');
	// Route::resource('/prescription',\App\Http\Controllers\Admin\PrescriptionController::class)->names('admin.prescription');
	// Route::resource('/page',\App\Http\Controllers\Admin\PageController::class)->names('admin.page');
	// //Transaction and wallet
	// Route::resource('/transaction',\App\Http\Controllers\Admin\TransactionController::class)->names('admin.transaction');
	// Route::resource('/wallet',\App\Http\Controllers\Admin\WalletController::class)->names('admin.wallet');

	// //user transaction
	// Route::get('/user/transaction',[\App\Http\Controllers\Admin\UserTransactionController::class,'index']);



});//middleware end


