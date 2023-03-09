<?php

namespace App\Http\Controllers\Api\V1\Doctor\Account;

use App\Helpers\UploadHandler;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorProfile;
use Illuminate\Http\Request;
use App\Models\DoctorEducation;

class DoctorProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function store(Request $request)
    {
		if($request->has('type') && !empty($request->type=='profile')){
			$profile=DoctorProfile::where('doctor_id',auth()->id())->first();
			if(!$profile){
				$profile=new DoctorProfile();
			}
			// $profile->email=$request->email??auth()->user()->email;
			// $profile->mobile=$request->mobile??auth()->user()->mobile;
			$profile->address  = $request->address??NULL;
			$profile->address_2  = $request->address_2??NULL;
			$profile->city  = $request->city??NULL;
			$profile->postcode  = $request->postcode??NULL;
			$profile->state  = $request->state??NULL;
			$profile->country  = $request->country??'India';
			$profile->gender  = $request->gender??NULL;
			$profile->dob  = $request->dob??NULL;
			$profile->age  = $request->age??NULL;
			$profile->yrs_of_exp  = $request->yrs_of_exp??NULL;//removed in next version
			$profile->experience  = $request->yrs_of_exp??NULL;
			$profile->experience_class  = $request->experience_class??'year';
			$profile->doctor_id=auth()->id();
			if($request->hasFile('image')){
				$upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/doctor/image/','upload_url'=>asset('uploads/doctor/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|webp)$/i',]);
				$image=$upload->get_response()['image'][0]->url;
				$profile->image=$image;
			}
			//signature
			if($request->hasFile('signature')){
				$upload=new UploadHandler(['param_name'=>'signature','upload_dir'=>'public/uploads/doctor/image/','upload_url'=>asset('uploads/doctor/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|webp)$/i',]);
				$signature=$upload->get_response()['signature'][0]->url;
				$profile->signature=$signature;
			}
			//stamp
			if($request->hasFile('stamp')){
				$upload=new UploadHandler(['param_name'=>'stamp','upload_dir'=>'public/uploads/doctor/image/','upload_url'=>asset('uploads/doctor/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|webp)$/i',]);
				$stamp=$upload->get_response()['stamp'][0]->url;
				$profile->stamp=$stamp;
			}
			$profile->save();

			if($request->has('specialist') && !empty($request->specialist)){
				$specialist=\App\Models\DoctorSpecialist::updateOrCreate([
                    'doctor_id'=>auth()->id()
                ],[
                    'doctor_id'=>auth()->id(),
                    'specialist_id'=>$request->specialist
                ]);
			}
			if(!$profile){
				return response()->json([
					'error' => true,
					'message' => 'Unknown Error!',
				], 422);
			}
			return response()->json([
				'success' => true,
				'message' => 'Doctor Profile Completed successfully',
				'data' => $profile
			], 200);


		}
		if($request->has('type') && !empty($request->type=='education')){
			$profile=DoctorProfile::where('doctor_id',auth()->id())->first();
			if(!$profile){
				$profile=new DoctorProfile();
			}
			if($request->has('education') && count($request->education)>0){
				foreach($request->education as $items){
					$education=DoctorEducation::updateOrCreate([
						'name'=>$items['degree'],
						'doctor_id'=>auth()->id()

					],[
						'name'=>$items['degree'],
						'institute'=>$items['institute'],
						'year'=>$items['year']
					]);
				}
			}
			//if($request->has('degree') && $request->has('institute') && $request->has('year')){
				if($request->has('yrs_of_exp') && !empty($request->yrs_of_exp)){
					$profile->yrs_of_exp  = $request->yrs_of_exp??'';//removed in next version
				}
				if($request->has('yrs_of_exp') && !empty($request->yrs_of_exp)){
					$profile->experience  = $request->yrs_of_exp??'';
					$profile->experience_class  = $request->experience_class??'year';
				}
				if($request->has('registration_number') && !empty($request->registration_number)){
					$profile->registration_number=$request->registration_number??'';
				}
				if($request->has('registration_council') && !empty($request->registration_council)){
					$profile->registration_council=$request->registration_council??'';
				}
				if($request->has('registration_year') && !empty($request->registration_year)){
					$profile->registration_year=$request->registration_year??'';
				}
				$profile->save();
				$education=DoctorEducation::updateOrCreate([
					//'name'=>$request->degree,
					'doctor_id'=>auth()->id()
				],[
					'name'=>$request->degree,
					'institute'=>$request->institute,
					'year'=>$request->year
				]);

			//}

			return response()->json([
				'success' => true,
				'message' => 'Doctor Profile Completed successfully',
				'data' => $profile
			], 200);
		}
		//first time create profile
        $profile=DoctorProfile::where('doctor_id',auth()->id())->first();
		if(!$profile){
            $profile=new DoctorProfile();
        }

			// $profile->email=$request->email??auth()->user()->email;
			// $profile->mobile=$request->mobile??auth()->user()->mobile;
			$profile->address  = $request->address??NULL;
			$profile->address_2  = $request->address_2??NULL;
			$profile->city  = $request->city??NULL;
			$profile->postcode  = $request->postcode??NULL;
			$profile->state  = $request->state??NULL;
			$profile->country  = $request->country??'India';
			$profile->gender  = $request->gender??NULL;
			$profile->dob  = $request->dob??NULL;
			$profile->age  = $request->age??NULL;

			$profile->doctor_id=auth()->id();
			if($request->hasFile('image')){
				$upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/doctor/image/','upload_url'=>asset('uploads/doctor/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|webp)$/i',]);
				$image=$upload->get_response()['image'][0]->url;
				$profile->image=$image;
			}
			//signature
			if($request->hasFile('signature')){
				$upload=new UploadHandler(['param_name'=>'signature','upload_dir'=>'public/uploads/doctor/image/','upload_url'=>asset('uploads/doctor/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|webp)$/i',]);
				$signature=$upload->get_response()['signature'][0]->url;
				$profile->signature=$signature;
			}
			//stamp
			if($request->hasFile('stamp')){
				$upload=new UploadHandler(['param_name'=>'stamp','upload_dir'=>'public/uploads/doctor/image/','upload_url'=>asset('uploads/doctor/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|webp)$/i',]);
				$stamp=$upload->get_response()['stamp'][0]->url;
				$profile->stamp=$stamp;
			}
			$profile->save();
			if($request->has('specialist') && !empty($request->specialist)){
				$specialist=\App\Models\DoctorSpecialist::updateOrCreate([
                    'doctor_id'=>auth()->id()
                ],[
                    'doctor_id'=>auth()->id(),
                    'specialist_id'=>$request->specialist
                ]);
			}



			if($request->has('education') && count($request->education)>0){
				foreach($request->education as $items){
					$education=DoctorEducation::updateOrCreate([
						'name'=>$items['degree'],
						'doctor_id'=>auth()->id()
					],[
						'name'=>$items['degree'],
						'institute'=>$items['institute'],
						'year'=>$items['year']
					]);
				}
			 }

				if($request->has('yrs_of_exp') && !empty($request->yrs_of_exp)){
					$profile->yrs_of_exp  = $request->yrs_of_exp??'';//removed in next version
				}
				if($request->has('yrs_of_exp') && !empty($request->yrs_of_exp)){
					$profile->experience  = $request->yrs_of_exp??'';
					$profile->experience_class  = $request->experience_class??'year';
				}
				if($request->has('registration_number') && !empty($request->registration_number)){
					$profile->registration_number=$request->registration_number??'';
				}
				if($request->has('registration_council') && !empty($request->registration_council)){
					$profile->registration_council=$request->registration_council??'';
				}
				if($request->has('registration_year') && !empty($request->registration_year)){
					$profile->registration_year=$request->registration_year??'';
				}
				$profile->save();
				$education=DoctorEducation::updateOrCreate([
					//'name'=>$request->degree,
					'doctor_id'=>auth()->id()
				],[
					'name'=>$request->degree,
					'institute'=>$request->institute,
					'year'=>$request->year
				]);



			return response()->json([
				'success' => true,
				'message' => 'Doctor Profile Completed successfully',
				'data' => $profile
			], 200);


    }

    public function old_store(Request $request)
    {

        $doctor = Doctor::find(auth()->id());
            $doctor->email  = $request->email;
            $doctor->mobile  = $request->mobile;
            $doctor->save();


        $doctorprofile=DoctorProfile::updateOrCreate([
            'doctor_id'=>auth()->id()
        ],[
            'address'  => $request->address??NULL,
            'address_2'  => $request->address_2??NULL,
            'age'   => $request->age??NULL,
            'gender'  => $request->gender??NULL,
            'state'  => $request->state??NULL,
            'tenth_std'  =>$request->tenth_std??NULL,
            'twelfth_std'  =>$request->twelfth_std??NULL,
            'graduation'  =>$request->graduation??NULL,
            'degree'  =>$request->degree??NULL,
			'experience'  => $request->yrs_of_exp??NULL,
			'experience_class'  => $request->yrs_of_exp??'year',
            'yrs_of_completion'  =>$request->yrs_of_completion??NULL,
            'registration_number'  =>$request->registration_number??NULL,
            'registration_council'  =>$request->registration_council??NULL,
            'registration_year'  =>$request->registration_year??NULL,

        ]);
        if($request->hasFile('image')){
            $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/doctor/image/','upload_url'=>asset('uploads/doctor/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|webp)$/i',]);
            $image=$upload->get_response()['image'][0]->url;
            $doctorprofile=DoctorProfile::updateOrCreate([
                'doctor_id'=>auth()->id()
            ],[
                'image'=>$image
            ]);
        }
        // $doctorprofile->address  = $request->address??"",
        // $doctorprofile->age  = $request->age;
        // $doctorprofile->gender  = $request->gender;
        // $doctorprofile->state  = $request->state;
        // if($request->hasFile('image')){
        //     $upload=new UploadHandler(['param_name'=>'image','upload_dir'=>'public/uploads/doctor/image/','upload_url'=>asset('uploads/doctor/image/').'/','image_versions'=>[],'print_response'=>false,'accept_file_types' => '/\.(gif|jpe?g|png|webp)$/i',]);
        //     $doctorprofile->image=$upload->get_response()['image'][0]->url;
        // }
        // $doctorprofile->tenth_std  =$request->tenth_std;
        // $doctorprofile->twelfth_std  =$request->twelfth_std;
        // $doctorprofile->graduation  =$request->graduation;
        // $doctorprofile->degree  =$request->degree;
        // $doctorprofile->yrs_of_exp  = $request->yrs_of_exp;
        // $doctorprofile->yrs_of_completion  =$request->yrs_of_completion;
        // $doctorprofile->registration_number  =$request->registration_number;
        // $doctorprofile->registration_council  =$request->registration_council;
        // $doctorprofile->registration_year  =$request->registration_year;
        // if(!$doctorprofile){
        //     return response()->json(['error' => 'Please wait till Admin activate your account','status'=>$doctorprofile],422);
        //     }
        $doctorprofile->save();


        $doctoreducation=DoctorEducation::updateOrCreate([
            'doctor_id'=>auth()->id()

        ],
        [

            'name' => $request->name??NULL,
            'institute' =>$request->institute??NULL,
            'year' =>   $request->year??NULL
        ]);


        // $doctoreducation->name = $request->name;
        // $doctoreducation->institute =$request->institute;
        // $doctoreducation->year =   $request->year;

        // $doctoreducation->save();


        return response()->json([
            'success' => true,
            'message' => 'Doctor Profile Completed successfully',
            'doctor' => $doctor,
            'doctor profile' => $doctorprofile,
            // 'doctor education' => $doctoreducation,
        ], 200);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store_education(Request $request)
    {
    //   $doctoreducation=DoctorEducation::where('doctor_id',auth()->id())->first();
    //   $doctoreducation->name = $request->name;;
    //   $doctoreducation->institue =$request->institue;
    //   $doctoreducation->year =   $request->year;
    //   $doctoreducation->save();

    //   return response()->json([
    //     'success' => true,
    //     'message' => 'Doctor Profile Completed successfully',
    //     'data' => $doctoreducation
    // ], 200);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profile_status(){
        $doctor_status = Doctor::select('status')->find(auth()->id());
        if($doctor_status->status == 1){
            $doctor_status->status = 2;
            return response()->json([
            'status'=>$doctor_status->status,
            // 'profile_status'=>$doctor_status->status
        ], 200);
        }

        $doctor=DoctorProfile::where('doctor_id',auth()->id())->first();
        if (!$doctor) {
            return response()->json(['error'=>true,'status'=> 0],200);//prompt in app for uploading doctor profile data
        }

// dd($doctor)
        if(!$doctor->yrs_of_exp   ||  !$doctor->yrs_of_completion  ||  !$doctor->registration_number    ||  !$doctor->registration_council   ||  !$doctor->registration_year ){

            $doctor_status->status = 0;//prompt in app for uploading doctor profile data
        }else{
            $doctor_status->status = 1;//doctor profile data update successfully, then in app it show please wait for approval screen
        }



        if (!$doctor) {
            return response()->json(['error'=>true,'message'=>'Something went worng']);
        }
        return response()->json([
            'status'=>$doctor_status->status,
            // 'profile_status'=>$doctor_status->status
        ], 200);
    }
}
