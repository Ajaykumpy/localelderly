<?php

namespace App\Http\Controllers\Api\V1\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=\App\Models\User::when('filter',function($q){
            if(request()->has('meeting_id') && !empty(request()->meeting_id)){
                $q->join('call_requests','users.id','=','call_requests.patient_id');
                $q->where('call_requests.meeting_id',request()->meeting_id);
            }
            if(request()->has('user_id') && !empty(request()->user_id)){
                $q->where('users.id',request()->user_id);
            }
        })
        ->select('users.id as patient_id','users.mobile','users.email','users.name','users.age','users.dob','users.height','users.weight','users.blood_group','users.existing_disease')
        ->first();
        if(!$user){
            return response()->json(['error'=>true,'message'=>'No record found'],422);
        }
        if($user){
            $user->mobile =   strval($user->mobile);
        }
        if($user){
            $age =    getAge($user->dob??NULL);
            $user->age =   strval($age);
        }
        if($user){
            $bmi =    getBmi($user->height??NULL,  $user->weight??NULL);
            $user->bmi =   strval($bmi);
        }
        return response()->json($user);
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
        \Log::info('Meeting id: '.request()->meeting_id);
        $user=\App\Models\User::when('filter',function($q){
            if(request()->has('meeting_id') && !empty(request()->meeting_id)){
                $q->join('call_requests','users.id','=','call_requests.patient_id');
                $q->where('call_requests.meeting_id',request()->meeting_id);
            }
            if(request()->has('user_id') && !empty(request()->user_id)){
                $q->where('users.id',request()->user_id);
            }
        })
        ->select('users.name','users.age','users.height','users.weight','users.blood_group','users.existing_disease')
        ->first();
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
