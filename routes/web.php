<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\Program\ProgramController;
use App\Http\Controllers\Doctor\DashboardController;
use App\http\Controllers\Doctor\AppointmentController;
use App\http\Controllers\Doctor\PrescriptionController;
use App\http\Controllers\Doctor\CallLogController;
use App\Http\Controllers\Api\V1\Doctor\DoctorStatusController;
use App\Http\Middleware\DoctorCheckStatus;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',[AuthController::class, 'index']);
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('auth', [AuthController::class, 'authenticate']);
Route::get('logout', [AuthController::class, 'signOut'])->name('signout');
 Route::get('/clear-cache', function() {
     Artisan::call('cache:clear');
     Artisan::call('view:clear');
     Artisan::call('config:cache');
    dd('done');
    // return what you want
});


//program route

// //Doctor Panel
// Route::prefix('doctor')->name('doctor.')->group(function(){
//     Route::get('/', [\App\Http\Controllers\Doctor\Auth\LoginController::class, 'showLoginForm'])->name('login');
//     Route::get('login', [\App\Http\Controllers\Doctor\Auth\LoginController::class, 'showLoginForm'])->name('login');
//     Route::post('login', [\App\Http\Controllers\Doctor\Auth\LoginController::class, 'login'])->name('login');
//     Route::any('logout', [\App\Http\Controllers\Doctor\Auth\LoginController::class, 'logout'])->name('logout');
//     //Route::get('logout', [AuthController::class, 'signOut'])->name('signout');
//     Route::middleware(['auth:doctor',DoctorCheckStatus::class])->group(function(){
//        //Route::resource('/',\App\Http\Controllers\Doctor\DashboardController::class)->names('doctor');
//        Route::get('/profile', [\App\Http\Controllers\Doctor\ProfileController::class, 'edit']);
//        Route::put('/profile', [\App\Http\Controllers\Doctor\ProfileController::class, 'update']);
//        Route::get('/dashboard', [\App\Http\Controllers\Doctor\DashboardController::class, 'index'])->name('dashboard');
//        Route::get('/appoinment/{id}/video-call',[\App\Http\Controllers\Doctor\AppointmentController::class,'video_call'])->name('appoinment.call.video');
// 	   Route::get('/appoinment/{id}/voice-call',[\App\Http\Controllers\Doctor\AppointmentController::class,'voice_call'])->name('appoinment.call.voice');
//        Route::resource('appoinment',\App\Http\Controllers\Doctor\AppointmentController::class)->names('appoinment');
//        Route::post('appointment/end/call',[\App\Http\Controllers\Doctor\AppointmentController::class,'appointment_call_end']);
//        Route::post('appointment/status/complete',[\App\Http\Controllers\Doctor\AppointmentController::class,'appointment_call_completed']);
//        Route::post('appointment/not/pickup ',[\App\Http\Controllers\Doctor\AppointmentController::class,'appointment_not_connected']);
//        Route::get('/prescription/pdf/{id}',[\App\Http\Controllers\Doctor\PrescriptionController::class,'download_pdf'])->name('prescription.pdf');
//        Route::resource('prescription',\App\Http\Controllers\Doctor\PrescriptionController::class)->names('prescription');
//        Route::resource('/call_log',\App\Http\Controllers\Doctor\CallLogController::class)->names('call_log');
//        Route::post('internal/status/online',[DoctorStatusController::class,'online']);
//        Route::any('internal/status/offline',[DoctorStatusController::class,'offline']);
//        Route::any('internal/check/status',[DoctorStatusController::class,'check_status']);
//     });

// });
